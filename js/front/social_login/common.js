function theChampLoadingIcon(){jQuery(".the_champ_login_container").html('<img id="the_champ_loading_image" src="'+theChampLoadingImgPath+'" />')}function theChampAjaxUserAuth(e,t){theChampLoadingIcon(),jQuery.ajax({type:"POST",dataType:"json",url:theChampAjaxUrl,data:{action:"the_champ_user_auth",profileData:e,provider:t,redirectionUrl:theChampTwitterRedirect?theChampTwitterRedirect:""},success:function(e){var t=theChampSiteUrl;if(1==e.status)t="register"==e.message?e.url&&""!=e.url?e.url:theChampRegRedirectionUrl+(theChampCommentFormLogin?"/#commentform":""):"linked"==e.message?theChampLinkingRedirection+"?linked=1":e.url&&""!=e.url?e.url:theChampRedirectionUrl+(theChampCommentFormLogin?"/#commentform":"");else if(null!==e.message.match(/ask/)){var a=e.message.split("|");t=theChampSiteUrl+"?SuperSocializerEmail=1&par="+a[1]}else"unverified"==e.message?t=theChampSiteUrl+"?SuperSocializerUnverified=1":"not linked"==e.message?t=theChampLinkingRedirection+"?linked=0":"provider exists"==e.message&&(t=theChampLinkingRedirection+"?linked=2");location.href=t},error:function(){location.href=decodeURIComponent(theChampRedirectionUrl)}})}function theChampInitiateLogin(e){var t=e.getAttribute("alt");if("Login with Facebook"==t)theChampAuthUserFB();else if("Login with Twitter"==t)theChampPopup(theChampSiteUrl+"?SuperSocializerAuth=Twitter&super_socializer_redirect_to="+theChampTwitterRedirect);else if("Login with Xing"==t)theChampPopup(theChampSiteUrl+"?SuperSocializerAuth=Xing&super_socializer_redirect_to="+theChampTwitterRedirect);else{if("Login with Linkedin"==t)return IN.User.authorize(),!1;"Login with Google"==t?theChampInitializeGPLogin():"Login with Vkontakte"==t?theChampInitializeVKLogin():"Login with Instagram"==t&&theChampInitializeInstaLogin()}}function theChampDisplayLoginIcon(e,t){if("undefined"!=typeof jQuery)for(var a=0;a<t.length;a++)jQuery("."+t[a]).css("display","block");else for(var a=0;a<t.length;a++)for(var i=theChampGetElementsByClass(e,t[a]),h=0;h<i.length;h++)i[h].style.display="block"}function theChampValidateEmail(e){var t=/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;return t.test(e)}function the_champ_save_email(e){var t=document.getElementById("the_champ_email").value.trim(),a=document.getElementById("the_champ_confirm_email").value.trim();return"save"!=e.id||theChampValidateEmail(t)?t!=a?(document.getElementById("the_champ_error").innerHTML="Email addresses do not match",void jQuery("#TB_ajaxContent").css("height","auto")):void theChampCallAjax(function(){theChampSaveEmail(e.id,t)}):(document.getElementById("the_champ_error").innerHTML=theChampEmailPopupErrorMsg,void jQuery("#TB_ajaxContent").css("height","auto"))}function theChampSaveEmail(e,t){document.getElementById("the_champ_error").innerHTML='<img src="'+theChampLoadingImgPath+'" />',jQuery.ajax({type:"POST",dataType:"json",url:theChampAjaxUrl,data:{action:"the_champ_save_email",elemId:e,email:t,id:theChampEmailPopupUniqueId},success:function(e){window.history.pushState({html:"html",pageTitle:"page title"},"","?done=1"),1==e.status&&e.message.response&&"success"==e.message.response?location.href=e.message.url:1==e.status&&"success"==e.message?location.href=theChampRegRedirectionUrl:1==e.status&&"cancelled"==e.message?tb_remove():1==e.status&&"verify"==e.message?document.getElementById("TB_ajaxContent").innerHTML="<strong>"+theChampEmailPopupVerifyMessage+"</strong>":0==e.status&&(document.getElementById("the_champ_error").innerHTML=e.message,jQuery("#TB_ajaxContent").css("height","auto"))},error:function(){location.href=decodeURIComponent(theChampRedirectionUrl)}})}function theChampCapitaliseFirstLetter2(e){return e.charAt(0).toUpperCase()+e.slice(1)}theChampVerified&&theChampLoadEvent(function(){tb_show(theChampPopupTitle,theChampAjaxUrl)}),theChampEmailPopup&&theChampLoadEvent(function(){tb_show(theChampEmailPopupTitle,theChampEmailAjaxUrl)});var theChampCommentFormLogin=!1;Modernizr.svg||jQuery(function(){jQuery(".the_champ_login_ul i").each(function(){var e=theChampCapitaliseFirstLetter2(jQuery(this).attr("alt").replace("Login with ","").toLowerCase());jQuery(this).attr("class","theChampLogin theChampLoginButton theChamp"+e+"Button").attr("style","display:block;width:32px;height:32px").find("div").remove()})});