(function() {
  player1.recorder.controller('Controls', [
    '$scope','$rootScope','$location', '$document','$analytics','$window', function($scope, $rootScope, $location, $document,$analytics,$window) {
      var track;
      $scope.recordingLength = function() {
        return Math.max(player1.player().recording.frameData.length - 1, 0);
      };
      track = function(action, options) {
        if (options == null) {
          options = {};
        }
        options.category = 'controls';
        return $analytics.eventTrack('record', options);
      };
      $scope.mode = '';
      $scope.leftHandlePosition;
      $scope.rightHandlePosition;
      $scope.inDigestLoop = false;
      $scope.pinHandle = '';
      $scope.$watch('leftHandlePosition', function(newVal, oldVal) {
        if (newVal === oldVal) {
          return;
        }
        if ($scope.mode !== 'crop') {
          return;
        }
        player1.player().setFrameIndex(parseInt(newVal, 10));
        return player1.player().recording.leftCrop();
      });
      $scope.$watch('rightHandlePosition', function(newVal, oldVal) {
        if (newVal === oldVal) {
          return;
        }
        if ($scope.inDigestLoop) {
          return;
        }
        player1.player().setFrameIndex(parseInt(newVal, 10));
      });
      $scope.$watch('mode', function(newVal, oldVal) {
        /*if (newVal !== 'record') {
          document.getElementById('record').blur();
        }
        if (newVal !== 'crop') {
          return document.getElementById('crop').blur();
        }*/
      });
      player2.controller.on('playback.record', function() {
        player1.controller.plugins.playback.player.toggle();
        $scope.pinHandle = 'min';
        return $scope.mode = 'playback';
      });
      player1.controller.on('playback.play', function() {
        $scope.pinHandle = 'min';
        return $scope.mode = 'playback';
      }).on('playback.ajax:begin', function() {
        $scope.playback();
        if (!$scope.$$phase) {
          return $scope.$apply();
        }
      }).on('playback.playbackFinished', function() {
        return $scope.$apply();
      });
      $scope.pauseOnPlaybackButtonClick = function() {
        return $scope.mode === 'playback' && player1.player().state !== 'idle';
      };
      $scope.canPlayBack = function() {
        return !player1.player().loaded();
      };
      $scope.playback = function() {
        if ($scope.mode === 'record') {
          player1.player().recording.setFrames(player2.player().recording.frameData);
        }
        
        player1.player().toggle();
        return track('playback');
      };
      player1.controller.on('frame', function(frame) {
        if ($scope.$$phase) {

          console.warn('Oops, already applying.');
          return;
        }
        $scope.inDigestLoop = true;
        $scope.$apply(function() {
          if ($scope.mode === 'playback') {
            //if(tempSimilarityResults != undefined){
              tempSimilarityResults.player1frame.id = frame.data.id;
              cmp1 = onProtocol(frame);//
              tempSimilarityResults.player1frame.eArray = cmp1;
            //}
            $scope.leftHandlePosition = player1.player().recording.leftCropPosition;
            return $scope.rightHandlePosition = player1.player().recording.frameIndex;
          }
        });
        return $scope.inDigestLoop = false;
      });
      
    }
  ]);
  player2.recorder.controller('Controls', [
    '$scope', '$rootScope', '$location', '$document', '$analytics', function($scope, $rootScope, $location, $document, $analytics) {
      var track;
      $scope.recordingLength = function() {
        return Math.max(player2.player().recording.frameData.length - 1, 0);
      };
      track = function(action, options) {
        if (options == null) {
          options = {};
        }
        options.category = 'controls';
        return $analytics.eventTrack('record', options);
      };
      $scope.mode = '';
      $scope.leftHandlePosition;
      $scope.rightHandlePosition;
      $scope.inDigestLoop = false;
      $scope.pinHandle = '';
      $scope.$watch('leftHandlePosition', function(newVal, oldVal) {
        if (newVal === oldVal) {
          return;
        }
        if ($scope.mode !== 'crop') {
          return;
        }
        player2.player().setFrameIndex(parseInt(newVal, 10));
        return player2.player().recording.leftCrop();
      });
      $scope.$watch('rightHandlePosition', function(newVal, oldVal) {
        if (newVal === oldVal) {
          return;
        }
        if ($scope.inDigestLoop) {
          return;
        }
        player2.player().setFrameIndex(parseInt(newVal, 10));
        if ($scope.mode === 'crop') {
          return player2.player().recording.rightCrop();
        }
      });
      $scope.$watch('mode', function(newVal, oldVal) {
        if (newVal !== 'record') {
          if(document.getElementById('record')!= null){
            document.getElementById('record').blur();
          }
        }
        if (newVal !== 'crop') {
          if(document.getElementById('crop') != null){
            return document.getElementById('crop').blur();
          }
        }
      });
      $scope.record = function() {        
        if (player2.player().state === 'recording') {
          if (player2.player().recordPending()) {
            return player2.player().stop();
          } else {
            return player2.player().finishRecording();
          }
        } else {
          player2.player().record();
          return track('record');
        }
      };
      player2.controller.on('playback.record', function() {
        similarityResult = [];
        return $scope.mode = 'record';
      }).on('playback.play', function() {
        player1.controller.plugins.playback.player.toggle();
        $scope.pinHandle = 'min';
        return $scope.mode = 'playback';
      }).on('playback.ajax:begin', function() {
        $scope.playback();
        if (!$scope.$$phase) {
          return $scope.$apply();
        }
      }).on('playback.recordingFinished', function() {
        if (player2.player().loaded()) {
          track('recordFinished', {
            value: player2.player().recording.frameData.length
          });
          return $scope.crop();
        }
      }).on('playback.playbackFinished', function() {
        return $scope.$apply();
      });
      $scope.crop = function() {
        if ($scope.mode === 'record') {
          player2.player().recording.setFrames(player2.player().recording.frameData);
        }
        $scope.mode = 'crop';
        $scope.pinHandle = '';
        player2.player().playbackMode();
        setTimeout(function() {
          $scope.inDigestLoop = true;
          $scope.leftHandlePosition = player2.player().recording.leftCropPosition;
          $scope.rightHandlePosition = player2.player().recording.rightCropPosition;
          $scope.$apply();
          return $scope.inDigestLoop = false;
        }, 0);
        setTimeout(function() {
          return player2.player().sendFrame(player2.player().recording.currentFrame());
        }, 0);
        return track('crop');
      };
      $scope.pauseOnPlaybackButtonClick = function() {
        return $scope.mode === 'playback' && player2.player().state !== 'idle';
      };
      $scope.canPlayBack = function() {
        return !player2.player().loaded();
      };
      $scope.recordPending = function() {
        return player2.player().recordPending();
      };
      $scope.recording = function() {
        return player2.player().isRecording();
      };
      $scope.playback = function() {
        if ($scope.mode === 'record') {

          player2.player().recording.setFrames(player2.player().recording.frameData);
        }
        player2.player().toggle();
        return track('playback');
      };
      $document.bind('keypress', function(e) {
        /*switch (e.which) {
          case 32:
            e.originalEvent.target.blur();
            if ($scope.mode === 'record') {
              return $scope.record();
            } else {
              return $scope.playback();
            }
            break;
          case 102:
            if (document.body.requestFullscreen) {
              document.body.requestFullscreen();
            } else if (document.body.msRequestFullscreen) {
              document.body.msRequestFullscreen();
            } else if (document.body.mozRequestFullScreen) {
              document.body.mozRequestFullScreen();
            } else if (document.body.webkitRequestFullscreen) {
              document.body.webkitRequestFullscreen();
            }
            return track('fullscreen');
          case 114:
            return $scope.record();
          case 99:
            return $scope.crop();
          case 112:
            return $scope.playback();
          case 115:
            return $scope.save();
          case 47:
          case 63:
          case 105:
            return $('#helpModal').modal('toggle');
          case 109:
            return $('#metadata').modal('toggle');
          default:
            return console.log("unbound keycode: " + e.which);
        }*/
      });
      player2.controller.on('frame', function(frame) {
        if ($scope.$$phase) {

          console.warn('Oops, already applying.');
          return;
        }
        $scope.inDigestLoop = true;
        $scope.$apply(function() {
          if ($scope.mode === 'playback') {

            $scope.leftHandlePosition = player2.player().recording.leftCropPosition;
  
            var fnd = similarityResult.find(element => element.player2frame.id == frame.data.id);
            //var fnd = similarityResult.filter((element) => element.player2frame.id == frame.data.id)[0];
            var similarityIndex = (fnd != undefined)? fnd.similarityIndex:-1;
            //console.log(similarityResult.find(element => element.player2frame.id == frame.data.id))
            //rec = (fnd != undefined)? [fnd.player1frame.eArray,fnd.player2frame.eArray]:[[],[]];
            rec = (fnd != undefined)? [fnd.player1frame.eArray,fnd.player2frame.eArray]:[[],[]];
            $rootScope.$emit("cosSimilarityPlayback",[similarityIndex,rec]);
            return $scope.rightHandlePosition = player2.player().recording.frameIndex;
          }else if($scope.mode ==='record'){
            tempSimilarityResults.player2frame.id = frame.data.id;
            cmp2 = onProtocol(frame);
            tempSimilarityResults.player2frame.eArray = cmp2;
            rec = [cmp1,cmp2];
            $rootScope.$emit("cosSimilarity",[cosineSimilarity(cmp1,cmp2),rec]);
          }
        });
        return $scope.inDigestLoop = false;
      });
      $scope.save = function(format) {
        player2.player().recording.save(format);
        return track('save', {
          label: format
        });
      };
      $scope.submit = function(format) {
        //compute similarity total
        
        var resultTotal = resultTotal(similarityResult, 0.9999997); //tentative criteria
        var jsonFile = new Blob([ JSON.stringify(similarityResult)], 
                                  {
                                    type: "text/JSON;charset=utf-8"
                                  });
        var lzFile = player2.player().recording.exportBlob(format);
        
        var dataform =  new FormData();
        dataform.append('_token',user_info.token);
        dataform.append('id',pageid);
        dataform.append('resultScore',resultTotal);
        dataform.append('similarityResult',jsonFile);
        dataform.append('leapData',lzFile);
        $.ajax({
            url: 'patient',
            processData: false,
            contentType: false,
            mimeType: 'multipart/form-data',
            type:"POST",
            data: dataform,
            
            success:function(data){
              if(!success){
                var color = (success) ? "blue": "red";
                if(typeof msg != "object"){
                  var toastContent = "<span>" + msg + "</span>";
                      M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes: color + ' darken-4'
                        });
                }else{
                  for(errors of Object.values(msg)){
                        var toastContent = "<span>" + errors + "</span>";
                        M.toast({   html:toastContent,
                              displayLength:5000, 
                              classes: color + ' darken-4'
                          });
                    }
                }
                
              }else{
                var toastContent = "<span>Success</span>";
                    M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'blue darken-4'
                        });
              }
              return true;
            },error:function(data){ 
              return false;
            }
        });
        dataform = new FormData();
        dataform.append('_token',user_info.token);
        dataform.append('id',pageid);
        dataform.append('resultScore',-1);  //algo for computing score
        dataform.append('similarityResult',jsonFile);

        
        $.ajax({
            url: 'patient/result',
            processData: false,
            contentType: false,
            mimeType: 'multipart/form-data',
            type:"POST",
            data: dataform,
            
            success:function(data){
              if(!success){
                var color = (success) ? "blue": "red";
                if(typeof msg != "object"){
                  var toastContent = "<span>" + msg + "</span>";
                      M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes: color + ' darken-4'
                        });
                }else{
                  for(errors of Object.values(msg)){
                        var toastContent = "<span>" + errors + "</span>";
                        M.toast({   html:toastContent,
                              displayLength:5000, 
                              classes: color + ' darken-4'
                          });
                    }
                }
                
              }else{
                var toastContent = "<span>Success</span>";
                    M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'blue darken-4'
                        });
              }
              return true;
            },error:function(data){
              
              return false;
            }
        });
        return track('save', {
          label: format
        });
      };
      return $('#metadata, #helpModal').on('shown.bs.modal', function() {
        return track($(this).attr('id') + "Shown");
      });
    }
  ]);
}).call(this);
