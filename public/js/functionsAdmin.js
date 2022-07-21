$.ajaxSetup({ 
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Authorization':  "Bearer "+ $('meta[name="authToken"]').attr('content'),
        datatype: "JSON",
        method: "POST"
    },
    /*beforeSend: function(xhr) {
        xhr.setRequestHeader('Authorization', "Bearer "+ $('meta[name="authToken"]').attr('content'));
    }*/
});
$(document).ready(function(){
    $('select').formSelect();
    $('.scrollspy').scrollSpy();
    $('.materialboxed').materialbox();
    
	$('.sidenav').sidenav(
        {
        menuWidth: 300, // Default is 240
        edge: 'left', // Choose the horizontal origin
        closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
        }
    );
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal').modal({
        onOpenStart: $('ul.tabs').tabs(),
    });
	$('.collapsible').collapsible();
    submitUserListFilter();
});
// For todays date;
Date.prototype.today = function () { 
    return ((this.getDate() < 10)?"0":"") + this.getDate() +"/"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"/"+ this.getFullYear();
}

// For the time now
Date.prototype.timeNow = function () {
     return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
}
$('#a_l_user').click(function(){
    this.parentNode.className = "light-blue darken-4 active";
    document.getElementById('li_c_user').className = "";
    document.getElementById('li_activation').className = "";
    document.getElementById('listOfUsers').style.display = 'block';
    document.getElementById('createUser').style.display = 'none';
    document.getElementById('getActivationCode').style.display = 'none';
});
$('#a_c_user').click(function(){
    this.parentNode.className = "light-blue darken-4 active";
    document.getElementById('li_l_user').className = "";
    document.getElementById('li_activation').className = "";
    document.getElementById('createUser').style.display = 'block';
    document.getElementById('listOfUsers').style.display = 'none';
    document.getElementById('getActivationCode').style.display = 'none';
});
$('#a_activation').click(function(){
    this.parentNode.className = "light-blue darken-4 active";
    document.getElementById('li_l_user').className = "";
    document.getElementById('li_c_user').className = "";
    document.getElementById('getActivationCode').style.display = 'block';
    document.getElementById('listOfUsers').style.display = 'none';
    document.getElementById('createUser').style.display = 'none';   
});
function submitUserListFilter(){
    var formId = "f_user_list_filter";
    var div = formId + "_div";
    formId = '#' + formId;
    var dataform =  new FormData();

    dataform.append('_token',$('meta[name="csrf-token"]').attr('content'));
    dataform.append('order',$(formId+' [name=pd_order]')[0].value);
    dataform.append('user_types',$(formId+' [name=pd_user_type]')[0].value);
    
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
            console.table(msg);
            var cur = document.getElementById('ul_list_users');
            if(status == "validatorFail"){
                
                for(var message in msg){                    
                    var toastContent = "<span>" + msg[message] + "</span>";
                    M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
                }
            }else if(status == "fail"){
                var toastContent = "<span>" + msg + "</span>";
                M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
            }else if(status == "success"){
                var searchRes = msg;
                
                $('#ul_list_users').empty();
                var cur = document.getElementById('ul_list_users');
                var siteUrl = window.location.href.split('/')[2];
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

                    var a = addNode(header_li,'a',undefined,undefined,"btn waves-effect light-blue darken-3",undefined,undefined,"Profile");
                    //var siteUrl = window.location.href.split('/')[2];
                        a.href = "https://" + siteUrl + "/auth/profile/edit/" + result[0].code;
                        a.target = "_blank";
                    
                    
                    //$('.tabs').tabs();
                    //$('.collapsible').collapsible();
                    
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
function submitActivationForm(formId){
    var div = formId + "_div";
    formId = '#' + formId;
    var dataform =  new FormData();

    dataform.append('_token',$('meta[name="csrf-token"]').attr('content'));
    dataform.append('email',$(formId+' [name=email]')[0].value);
    
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
                var toastContent = "<span>" + msg + "</span>";
                M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
            }else if(status == "success"){
                var toastContent = "<span>" + msg + "</span>";
                M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'blue darken-4'
                        });
                
                var row = addNode(cur,'li',undefined,undefined,'collection-item',undefined,undefined,undefined);
                addNode(row,undefined,undefined,undefined,undefined,undefined,undefined,$(formId+' [name=email]')[0].value + " ");
                a = addNode(row,'a',undefined,undefined,"btn waves-effect btn-flat",undefined,undefined,"Copy");
                a.onclick = function(){
                    var text = msg;
                    var listener = function(ev) {
                        ev.clipboardData.setData("text/plain", text);
                        ev.preventDefault();
                    };
                    document.addEventListener("copy", listener);
                    document.execCommand("copy");
                    document.removeEventListener("copy", listener);
                    toastContent = "<span>" + "Copied Code: " + msg + "</span>";
                    M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'blue darken-4'
                        });
                };
                var a = addNode(row,'a',undefined,undefined,"secondary-content light-blue darken-3 btn waves-effect",undefined,undefined,"Edit");
                var siteUrl = window.location.href.split('/')[2];
                a.href = "https://" + siteUrl + "/auth/profile/edit/" + msg;
                a.target = "_blank";
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
function submitRegForm(){
	var formId = '#f_reg';
	var dataform =  new FormData();

	dataform.append('_token',$('meta[name="csrf-token"]').attr('content'));
	dataform.append('email',$(formId+' [name=email]')[0].value);
	dataform.append('user_types',$(formId+' [name=user_types]')[0].value);
	
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
            var cur = document.getElementById('code');
        	if(status == "validatorFail"){
        		
            	for(var message in msg){
            		
            		var toastContent = "<span>" + msg[message] + "</span>";
					M.toast({  html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
            	}
            }else if(status == "fail"){
                cur.innerHTML = " ";
            	var toastContent = "<span>" + msg + "</span>";
				M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
            }else if(status == "success"){
            	var toastContent = "<span>" + msg + "</span>";
                M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'blue darken-4'
                        });
                
                var row = addNode(cur,'li',undefined,undefined,'collection-item',undefined,undefined,undefined);
                addNode(row,undefined,undefined,undefined,undefined,undefined,undefined,$(formId+' [name=email]')[0].value + " ");
                a = addNode(row,'a',undefined,undefined,"btn waves-effect btn-flat",undefined,undefined,"Copy");
                a.onclick = function(){
                    var text = msg;
                    var listener = function(ev) {
                        ev.clipboardData.setData("text/plain", text);
                        ev.preventDefault();
                    };
                    document.addEventListener("copy", listener);
                    document.execCommand("copy");
                    document.removeEventListener("copy", listener);
                    toastContent = "<span>" + "Copied Code: " + msg + "</span>";
                    M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'blue darken-4'
                        });
                };
                var a = addNode(row,'a',undefined,undefined,"secondary-content btn waves-effect",undefined,undefined,"Edit");
                var siteUrl = window.location.href.split('/')[2];
                a.href = "https://" + siteUrl + "/auth/profile/edit/" + msg;
                a.target = "_blank";
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

function submitActivationForm(){
	var formId = '#f_activation';
	var dataform =  new FormData();

	dataform.append('_token',$('meta[name="csrf-token"]').attr('content'));
	dataform.append('email',$(formId+' [name=email]')[0].value);
	
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
        	var cur = document.getElementById('codeActivation');
            if(status == "validatorFail"){
        		
            	for(var message in msg){            		
            		var toastContent = "<span>" + msg[message] + "</span>"; 
					M.toast({  html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
            	}
            }else if(status == "fail"){
                //cur.innerHTML = " ";
            	var toastContent = "<span>" + msg + "</span>";
                M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
            }else if(status == "success"){
            	var toastContent = "<span>" + msg + "</span>";
				M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'blue darken-4'
                        });
                var row = addNode(cur,'li',undefined,undefined,'collection-item',undefined,undefined,undefined);
                addNode(row,undefined,undefined,undefined,undefined,undefined,undefined,$(formId+' [name=email]')[0].value + " ");
                a = addNode(row,'a',undefined,undefined,"btn waves-effect btn-flat",undefined,undefined,"Copy");
                a.onclick = function(){
                    var text = msg;
                    var listener = function(ev) {
                        ev.clipboardData.setData("text/plain", text);
                        ev.preventDefault();
                    };
                    document.addEventListener("copy", listener);
                    document.execCommand("copy");
                    document.removeEventListener("copy", listener);
                    toastContent = "<span>" + "Copied Code: " + msg + "</span>";
                    M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'blue darken-4'
                        });
                };
                var a = addNode(row,'a',undefined,undefined,"secondary-content btn waves-effect",undefined,undefined,"Edit");
                var siteUrl = window.location.href.split('/')[2];
                a.href = "https://" + siteUrl + "/auth/profile/edit/" + msg;
                a.target = "_blank";
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
var searchRes = [];
function searchPatientGroup(){
    var formId = '#f_getPatientGroup';
    var dataform =  new FormData();

    dataform.append('_token',$('meta[name="csrf-token"]').attr('content'));
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
            var cur = document.getElementById('patientGroups');
            if(status == "validatorFail"){
                
                for(errors of msg){
                    var toastContent = "<span>" + errors + "</span>";
                    M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'red darken-4'
                        });
                }
            }else if(status == "fail"){
                for(errors of msg){
                    var toastContent = "<span>" + errors + "</span>";
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
                cur.innerHTML = " ";
                for(result of searchRes){
                //for(var i = 0; i<searchRes.length;i++){
                    var res_id = result[0].id;

                    var row = addNode(cur,'li',undefined,undefined,'collection-item',undefined,undefined,undefined);
                    addNode(row,'input','h_pg_id'+res_id,'h_pg_id'+res_id,undefined,res_id,'hidden',undefined);
                    addNode(row,"span",undefined,undefined,undefined,undefined,undefined,result[0].text);
                    addNode(row,"span","pgsize"+res_id,undefined,undefined,undefined,undefined," group size: " + result[0].size + " ");
                    
                    var a = addNode(row,'button',"upcount"+res_id,undefined,"upcount tooltipped waves-effect waves-light-blue-accent-4 waves-ripple  light-blue darken-4",undefined,undefined,undefined);
                    a.setAttribute('data-toggle', 'tooltip');
                    a.setAttribute('data-placement', 'top');
                    a.setAttribute('title', 'Increase');
                     a.setAttribute('onclick','updatePGSize(' + res_id +',1)');
                    addNode(a,'i',undefined,undefined,"material-icons",undefined,undefined,"arrow_drop_up");
                    
                    a = addNode(row,'button',undefined,undefined,"downcount tooltipped waves-effect waves-light-blue-accent-4 waves-ripple  light-blue darken-4",undefined,undefined,undefined);
                    a.setAttribute('data-toggle', 'tooltip');
                    a.setAttribute('data-placement', 'top');
                    a.setAttribute('title', 'Decrease');
                    a.setAttribute('onclick','updatePGSize(' + res_id +',0)');
                    addNode(a,'i',undefined,undefined,"material-icons",undefined,undefined,"arrow_drop_down");

                    /*var a = addNode(row,'a',undefined,undefined,"secondary-content btn waves-effect",undefined,undefined,"Edit");
                    var siteUrl = window.location.href.split('/')[2];
                    a.href = "https://" + siteUrl + "/auth/group/edit/" + result[0].id;
                    a.target = "_blank";*/
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
$('button .upcount').click(function(){

});
function updatePGSize(id,type){
    var dataform =  new FormData();

    dataform.append('_token',$('meta[name="csrf-token"]').attr('content'));
    dataform.append('id',id);
    dataform.append('type',type);

    $.ajax({
        url: '/api/admin/updatepgcount',
        processData: false,
        contentType: false,
        method: "POST",
        data: dataform,
        success:function(data){
            var status = data.status;
            var msg = data.message;

            var u = $("#pgsize"+msg[0].id);
            u.empty();
            u.append(document.createTextNode(" group size: " + msg[0].size + " "));
            
            return true;
        },error:function(){
            for(errors of JSON.parse(data).message){
                var toastContent = "<span>" + errors + "</span>";
                M.toast({   html:toastContent,
                            displayLength:5000, 
                            classes:'blue darken-4'
                        });
            }
            return false;
        }
    });
}
