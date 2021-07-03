(function(){
  dataform = new FormData();
  dataform.append('_token',user_info.token);
  dataform.append('id',pageid);
  
  $.ajax({
      url: '/recordings/exer/result/',
      processData: false,
      contentType: false,
      type:"POST",
      data: dataform,
      
      success:function(data){
        var status = JSON.parse(data).status;
        var msg = JSON.parse(data).message;
        if(msg === null || msg === undefined){
          similarityResult = [];
        }else{
          similarityResult = msg[message]; 
        }
        return true;
      },error:function(data){ 
        return false;
      }
  });

}).call(this);