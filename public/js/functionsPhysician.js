var searchRes = [];
function searchPatient(){
    getLoading('ul_srch_res_pat');
    var formId = '#f_getPatientSrch';
    var dataform =  new FormData();

    //dataform.append('_token',$(formId + ' [name=_token]')[0].value);
    dataform.append('search',$(formId+' [name=search]')[0].value);
    
    var error;
    $.ajax({
        url: $(formId).attr('action'),
        processData: false,
        contentType: false,
        mimeType: 'multipart/form-data',
        method: "POST",
        data: dataform,
        
        success:function(data){
            var status = JSON.parse(data).status;
            var msg = JSON.parse(data).message;
            
            if(status == "validatorFail"){
                for(var message in msg){                    
                    var toastContent = "<span>" + msg[message] + "</span>";
                    M.toast({   html:toastContent,
                            displayLength:5000,
                            classes:'red darken-4'
                        });
                }
            }else if(status == "fail"){
                for(var message in msg){                    
                    var toastContent = "<span>" + msg[message] + "</span>";
                    M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
                }
            }else if(status == "success"){
                for(result of msg){
                    if(result.length != 0){
                        if(searchRes.length == 0){
                            searchRes.push(result);
                        }else{
                            var flg = 0; //no similar result
                            for(res of searchRes){
                                if(res[0].id == result[0].id){
                                    flg = 1;
                                    res[0].text = result[0].text;
                                    res[0].size = result[0].size;
                                    break;
                                }
                            }
                            if(flg==0){
                                searchRes.push(result);
                            }
                        }
                    }
                }
                
                var cur = document.getElementById('ul_srch_res_pat');

                cur.innerHTML = " ";
                for(result of searchRes){
                    var res_id = result[0].user_id;
                    
                    var li = addNode(cur,"li",undefined,undefined,undefined,undefined,undefined,undefined);
                             addNode(li,'input','h_pg_id'+res_id,'h_pg_id'+res_id,undefined,res_id,'hidden',undefined);
                    var div_header = addNode(li,"div",undefined,undefined,"collapsible-header");
                    var header_ul = addNode(div_header,"ul",undefined,undefined,"collection");
                    var header_li = addNode(header_ul,"li",undefined,undefined,"collection-item avatar");
                    var img_prof = addNode(header_li,"img",undefined,undefined,"profile circle");
                        img_prof.src = "https://" + siteUrl + "/discussion/image/"+result[0].profile;
                        img_prof.alt = 'notavailable';
                    var fullname = result[0].first_name + " " + result[0].middle_name + " " + result[0].last_name;
                        fullname += (result[0].suffix_name) ? result[0].suffix_name: " ";
                        addNode(header_li,"p",undefined,undefined,undefined,undefined,undefined,fullname);
                    var a = addNode(header_li,'a',undefined,undefined,"btn waves-effect",undefined,undefined,"Profile");
                    //var siteUrl = window.location.href.split('/')[2];
                        a.href = "https://" + siteUrl + "/auth/profile/edit/" + result[0].code;
                        a.target = "_blank";

                    var div_body = addNode(li,"div",undefined,undefined,"collapsible-body");
                    var row = addNode(div_body,"div",undefined,undefined,"row");
                    var div2 = addNode(row,"div");
                    var dtls_ul = addNode(div2,"ul",undefined,undefined,"tabs tabs-fixed-width tab-demo z-depth-1");
                    //thread/discussions
                    var dtls_tab = addNode(dtls_ul,"li",undefined,undefined,"tab");
                        a = addNode(dtls_tab,"a",undefined,undefined,"active",undefined,undefined,"Threads");
                        a.href = "#patientResThread"+res_id;
                        a.onclick = function(){loadDiscs(res_id)};
                    //tasks    
                        dtls_tab = addNode(dtls_ul,"li",undefined,undefined,"tab");
                        a = addNode(dtls_tab,"a",undefined,undefined,undefined,undefined,undefined,"Tasks");
                        a.href = "#patientResTask"+res_id;
                        a.onclick = function(){loadTasks(res_id)};
                    //notes
                        dtls_tab = addNode(dtls_ul,"li",undefined,undefined,"tab");
                        a = addNode(dtls_tab,"a",undefined,undefined,undefined,undefined,undefined,"Notes");
                        a.href = "#patientResNotes"+res_id;
                        a.onclick = function(){ loadNotes(res_id) };
                        
                    var d = addNode(div2,"div","patientResThread"+result[0].user_id,undefined,"col s12",undefined,undefined,undefined);
                    var d_t_d = addNode(d,"div",undefined,undefined,"container");
                        addNode(d_t_d,"ul",undefined,undefined,"modal-content collection");
                    var t = addNode(div2,"div","patientResTask"+result[0].user_id,undefined,"col s12",undefined,undefined,undefined);
                    var t_d = addNode(t,"div",undefined,undefined,"container");
                        addNode(t_d,"ul",undefined,undefined,"collapsible popout");
                    var notes = addNode(div2,"div",undefined,undefined,"col s12",undefined,undefined,undefined);
                        addNode(notes,"ul","patientResNotes"+res_id,undefined,"collapsible popout");
                    $('.tabs').tabs();
                    $('.collapsible').collapsible();
                    
                }
            }
        },error:function(data){ 
            error = data.status;
        }
    });
    if(error == undefined){
        return true;
    }
    return false;
}
function loadNotes(id){

    var data = {
        
        id:id
    }
    $.ajax({
      url: '/api/note/list/',
      data: data,
      method: "GET",
      success:function(data){

        if(data.status == 'success'){
            var ul = document.getElementById("patientResNotes"+id);
            if(data.notes.length > 0){
              for(info of data.notes){
                var artcle = {id:'',title:'',text:'',images:'',updated_at:''};
                    artcle.id    = info.id;
                    artcle.title   = info.title;
                    artcle.text    = info.text;
                    artcle.images   = info.images;
                    artcle.updated_at   = info.updated_at;
                console.log(info);

                var li = addNode(ul,"li",undefined,undefined,undefined,undefined,undefined,undefined);
                var div_header = addNode(li,"div",undefined,undefined,"collapsible-header");
                var header_ul = addNode(div_header,"ul",undefined,undefined,"collection");
                var header_li = addNode(header_ul,"li",undefined,undefined,"collection-avatar",undefined,undefined,"Note ID: "+artcle.id);

                if(Number.isInteger(info.exer_data)){
                    var secCont = addNode(header_li,"div",undefined,undefined,"secondary-content");
                        a = addNode(secCont,"a",undefined,undefined,"btn-flat tooltipped");
                        a.href = "https://" + siteUrl + "/tasks/" + info.exer_data;
                        a.target = "blank";
                        a.setAttribute('data-position',"left");
                        a.setAttribute("data-delay","50");
                        a.setAttribute("data-tooltip","Launch");
                        addNode(a,"i",undefined,undefined,"material-icons center",undefined,undefined,"launch");
                }
                var div_body = addNode(li,"div",undefined,undefined,"collapsible-body");
                var row = addNode(div_body,"div",undefined,undefined,"row");
                var div2 = addNode(row,"div",undefined,undefined,"col s12 m12 l12");
                var details = addNode(div2,"div","details"+artcle.id);
                var contents = addNode(div2,"div","contents"+artcle.id);
                updateNoteInfoDetail(artcle,details,contents);
                /*M.Collapsible.init();
                //$('#patientResNotes'+ id +' .collapsible').collapsible(); */
              }
            }else{
                var toastContent = "<span>No notes available</span>";
                M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
            }
        }else{
            var toastContent = "<span>" + data.message + "</span>";
            M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });   
        }
        
         
        return true;
      },error:function(data){ 
            error = data.status;
            return false;
      }
    });

}
function loadTasks(id){
    if($('#patientResTask'+id).is(':parent') ){
        $('#patientResTask'+id).empty();
    }
    getLoading('patientResTask'+id);

    var data = {
        project: project_id,
        patient_id: id,
        all: false
    }

    $.ajax({
        url: '/api/tasks/board',
        type:"POST",
        data: data,
        method: "POST",
        success:function(data){
            if(data.status == "fail"){
                var toastContent = "<span>" + data.message + "</span>";
                M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
            }else{
                if(data.tasks.length > 0){
                    var resTasks = [];
                    for(var i=0;i<data.tasks.length;i++){
                        var task = {creator_info:undefined,task_info:undefined,patient_info:undefined,exers_info:undefined};
                        task.creator_info = data.tasks[i].creator_info;
                        task.task_info = data.tasks[i].task_info;
                        task.patient_info = data.tasks[i].patient_info;
                        task.exers_info = data.tasks[i].exers_info;
                        
                        if(resTasks.length == 0){
                            resTasks.push(task);
                        }else{
                            
                            resTasks.unshift(task); //add items at the beginning of array
                               
                        }
                    }
                    if($('#patientResTask'+id).is(':parent') ){
                        $('#patientResTask'+id).empty();
                    }
                    var par = document.getElementById('patientResTask'+id);
                    var div = addNode(par,"div",undefined,undefined,"modal-content container");
                    var ul = addNode(div,"ul",undefined,undefined,"collapsible popout");
                    addNode(ul,"li");
                    
                    updateGenContentTasks(resTasks,'patientResTask'+id);
                }else{
                    var toastContent = "<span> No Tasks available. </span>";
                    M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
                }
                if(data.error.length >0){
                    for(var i=0;i<data.error.length;i++){
                        var toastContent = "<span> "+ data.error[i].status + "Patient ID: " + data.error[i].info + " </span>";
                        M.toast({   html:toastContent,
                                displayLength:5000, 
                                classes:'red darken-4'
                            });
                    }
                }
            }
            
            return true;
        },error:function(){ 
            alert("An Error!!!!");
            return false;
        }
    });
}
function loadDiscs(id){

    var data = {
        project: project_id,
        patient_id: id,
        all: false
        }
    var resDisc = [];
    $.ajax({
        url: '/api/discussion/board',
        type:"POST",
        data: data,
        method: "POST",
        success:function(data){
            for(var i=0;i< data.discussions.length;i++){
                var discussion = {profile:'',first_name:'',last_name:'',disc_id:'',disc_title:'',disc_text:''};
                    discussion.profile = data.discussions[i].profile;
                    discussion.first_name = data.discussions[i].first_name;
                    discussion.last_name = data.discussions[i].last_name;
                    discussion.disc_id = data.discussions[i].discussion_id;
                    discussion.disc_title = data.discussions[i].disc_title;
                    discussion.disc_text = data.discussions[i].disc_text;
                    discussion.priority = data.discussions[i].priority;

                if(resDisc.length == 0){
                    resDisc.push(discussion);
                }else{
                    if(function(){
                        for(var j=0;j<data.length;j++){
                            if(discussion.disc_id == resDisc[i].disc_id){
                                return false;
                            }
                        }
                        return true;
                    }){
                        resDisc.unshift(discussion); //add items at the beginning of array
                    }
                }
            }
            //$('.modal-content ul li','#patientResThread'+id).remove();
            updateModal2(resDisc,'patientResThread'+id);
            //launchGenContent(discussions[0].disc_id);
            //displayed_id = discussions[0].disc_id;
            return true;
        },error:function(){ 
            alert("An Error!!!!");
            return false;
        }
    });
}