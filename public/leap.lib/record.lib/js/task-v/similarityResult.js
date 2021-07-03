(function(){
  dataform = new FormData();
  dataform.append('_token',user_info.token);
  dataform.append('id',pageid);
  
  $.ajax({
      url: '/recordings/result',
      processData: false,
      contentType: false,
      type:"POST",
      data: dataform,
      
      success:function(data){
        var status = data.status;
        var msg = data.message;
          if(status == true){
            if(!msg){
              similarityResult = [];
            }else{
              similarityResult = msg; 
            }
          }else{
            similarityResult = [];
            if(msg != '[]'){
              var toastContent = "<span>" + msg + "</span>";
              M.toast({   html:toastContent,
                    displayLength:5000, 
                    classes:'red darken-4'
                });
            }
          }
        return true;
      },error:function(data){ 
        return false;
      }
  });

}).call(this);