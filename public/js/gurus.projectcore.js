///////////////////////////////////////////////////////////////////////////////////////
// INTERACTIVITY
var cInteractivity = new function () {

    this.objectName = "interactivity";

    this.doRequest = function (t, u, d, funcError) {
		return cAjax.doSyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcError);
    }

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    }
	
	this.clickOk = function () {
		var id = $("#modal-editor").attr("opener");
		var content = $("#editor").val();
		$("#comp-" + id + "-content").val(content);
		$("#modal-editor").addClass("hide");
		$("#modal-mask").addClass("hide");
		$("#editor").destroyEditor();
    }
	
	this.clickCancel = function () {
		$("#modal-editor").addClass("hide");
		$("#modal-mask").addClass("hide");
		$("#editor").destroyEditor();
    }
	
	this.openTransferModal = function (e) {
		
		var componentID = e.parents("li:first").attr("componentid");
		var pageNo = e.parents("li.page:first").attr("pageno");

		$(".transfer-modal .all, .transfer-modal .one").addClass("hide");

		if(typeof componentID === "undefined") {
			$(".transfer-modal .all").removeClass("hide");
		}
		else {
			var componentName = $("div.tree a[componentid='" + componentID + "']").html();
			var o = $(".transfer-modal .one span");
			var t = o.attr("text");
			t = t.replace("{component}", componentName);
			o.html(t);
			$(".transfer-modal .one").removeClass("hide");
		}

		$("#transferComponentID").val(componentID);
		$("#transferFrom").val(pageNo);
		$(".transfer-modal div p strong em").html(pageNo);

		$(".transfer-modal select option")
			.removeAttr("disabled")
			.eq(parseInt(pageNo) - 1)
			.attr("disabled", "disabled")
			.next()
			.prop('selected', true);

		//console.log(	$("#transferTo")	);
		//$("#transferTo").append('<option value="34">TEST</option>')

		if($("#transferTo").hasClass('chzn-done')) {
			$("#transferTo").removeClass('chzn-done')
			$("#transferTo").next().remove();
		}
		$("#transferTo").chosen();

		/*
		if($("#transferTo").hasClass('chzn-done')) {
			$("#transferTo").val('').trigger("chosen:updated");
		}
		else {
			$("#transferTo").chosen();
		}
		*/
		$(".transfer-modal").removeClass("hide");
		$("#modal-mask").removeClass("hide");
    }
    
    this.closeTransferModal = function () {
		
		$(".transfer-modal").addClass("hide");
		$("#modal-mask").addClass("hide");
    }

    this.transfer = function () {
		var contentFileID = $("#contentfileid").val();
		var componentID = $("#transferComponentID").val();
		var from = $("#transferFrom").val();
		var to = $("#transferTo").val();
		//console.log('kaydet', contentFileID, from, to);
		this.saveCurrentPage();

		var t = 'POST';
		var u = '/' + $('#currentlanguage').val() + '/' + route["interactivity_transfer"];
		var d = "contentfileid=" + contentFileID + "&componentid=" + componentID + "&from=" + from + "&to=" + to;
		var ret = cInteractivity.doRequest(t, u, d);
		if (ret.getValue("success") == "true") {
			this.refreshTree();
			this.clearPage();
			this.closeTransferModal();
		}
		else {
			cNotification.failure(ret.getValue("errmsg"));
		}
    }

	this.openSettings = function () {
		
		$(".compression-settings").removeClass("hide");
		$("#modal-mask").removeClass("hide");
    }
	
	this.closeSettings = function (dontUpdate) {
		
		dontUpdate = (typeof dontUpdate == "undefined") ? false : dontUpdate;
		
		if(!dontUpdate)
		{
			$(".compression-settings div.checkbox").removeClass("checked");
			
			if($("#included").val() == "1")
			{
				$(".compression-settings div.checkbox").addClass("checked");
			}
		}
		
		$(".compression-settings").addClass("hide");
		$("#modal-mask").addClass("hide");
    }
	
	this.saveSettings = function () {
		
		$("#included").val(0);
		
		if($(".compression-settings div.checkbox").hasClass("checked"))
		{
			$("#included").val(1);	
		}
		
		this.closeSettings(true);
    }
	
    this.refreshTree = function() {
    	var contentFileID = $("#contentfileid").val();
		var t = 'POST';
    	var u = '/' + $('#currentlanguage').val() + '/' + route["interactivity_refreshtree"];
		var d = "contentfileid=" + contentFileID;
		cInteractivity.doAsyncRequest(t, u, d, function (ret) {
			//Collapse destroy
			$('div.tree a').unbind('click');
			$('#tabs-2').html(ret.getValue("html"));
			//Collapse init
			//initTree();
			$('div.tree').collapse(false, true);
			$('div.tree a.selectcomponent').click(function(){ cInteractivity.selectComponent($(this)); });
		});
    }

	this.selectComponent = function (obj) {
		
		var currentPageNo = $("#pageno").val();
		var pageNo = obj.parents("li.page:first").attr("pageno");
		
		if(pageNo !== currentPageNo)
		{
			this.showPage(pageNo, false, cInteractivity.selectComponentOnCurrentPage, obj);
		}
		else
		{
			this.selectComponentOnCurrentPage(obj);
		}
    }
	
	this.selectComponentOnCurrentPage = function (obj) {
		
		var id = obj.attr("componentid");
		var tool = $("#tool-" + id);
		if(!tool.hasClass("selected"))
		{
			//hide all other components
			$("#component-container .component").addClass("hide");
			
			//show only selected components
			$("#component-container #prop-" + id).removeClass("hide");
				
			$(".gselectable").removeClass("selected");
			tool.addClass("selected");
		}
	}
	
	this.deleteComponentOnCurrentPage = function () {
		
		$("#page div.modal-component, #page div.tooltip-trigger").each(function(){
			
			var id = $(this).attr("componentid");

			$("#prop-" + id + " div.component-header a.delete").click();
		});
	}
	
	this.showPage = function (pageno, dontSave, func, obj)
	{
		dontSave = (typeof dontSave == "undefined") ? false : dontSave;

		if(!dontSave)
		{
			this.saveCurrentPage();
		}
		
		$("#pdf-container").addClass("loading");
		$("#page").css("display", "none");

		//remove active class
		$("div.thumblist ul.slideshow-slides li.each-slide").each(function(){
			$(this).removeClass('active');
		});
		//add active class to current page
		$("div.thumblist ul.slideshow-slides li.each-slide a[pageno='" + pageno + "']").parents("li:first").addClass('active');
		
		var pageCount = $("div.thumblist ul.slideshow-slides li.each-slide").length;
		
		$("#pageno").val(pageno);
		$("#pdf-page").val(pageno + '/' + pageCount);
		
		var src = $("div.thumblist ul.slideshow-slides li.each-slide a[pageno='" + pageno + "'] img").attr("src");
		
		$("#page").smoothZoom('destroy');
		
		var img = new Image();
		img.onload = function()
		{
			//console.log(src);
			$("#page")
				.css("background", "url('" + src + "') no-repeat top left")
				.css("width", img.width + "px")
				.css("height", img.height + "px");
			
			cInteractivity.clearPage();
			cInteractivity.loadPage(pageno, func, obj);

			if(!$("html").hasClass("lt-ie9"))
			{
				var h = $(window).innerHeight() - $("#pdf-container").offset().top - $("footer").outerHeight();
				
				$('#page').smoothZoom({
					width:'100%',
					//width:'740px',
					height: h + 'px',
					//initial_ZOOM: 100,
					responsive: true,
					pan_BUTTONS_SHOW: "NO",
					pan_LIMIT_BOUNDARY: "NO",
					button_SIZE: 24,
					button_ALIGN: "top right",    
					zoom_MAX: 500,
					border_TRANSPARENCY: 0,
					container: 'pdf-container',
					max_WIDTH: '',
					max_HEIGHT: ''
				});
			}
		}
		img.src = src;
    }
	
	this.clearPage = function()
	{
		$("#pdf-container .tooltip-trigger").remove();
		$("#pdf-container .modal-component").remove();
		
		$("#component-container").html("");
	}
	
	this.loadPage = function(pageno, func, obj)
	{
		//$(".loader").removeClass("hidden");
		var frm = $("#pagecomponents");
		var t = 'POST';
		var u = '/' + $('#currentlanguage').val() + '/' + route["interactivity_loadpage"];
		var d = cForm.serialize(frm);
		cInteractivity.doAsyncRequest(t, u, d, function (ret) {
			//Sayfa henuz yuklenmeden degistirilirse eski icerikleri gosterme!
			if(parseInt($("#pageno").val()) !== parseInt(pageno)) 
				return;

			$("#page").append(ret.getValue("tool"));
			$("#component-container").html(ret.getValue("prop"));
			
			/*
			//TODO:duzelt
			var zoomData = $('#page').smoothZoom('getZoomData');
			
			$("#page").smoothZoom('focusTo', {
				x: parseInt(zoomData.centerX),
				y: parseInt(zoomData.centerY),
				zoom: 100
			});
			*/
			
			//Collapse destroy
			$('div.tree a').unbind('click');
			
			$("#page div.modal-component, #page div.tooltip-trigger").each(function(){
				
				var componentName = $(this).attr("componentname");
				var id = $(this).attr("componentid");
				var arr = $(this).attr("data-position").split(',');
				var left = parseInt(arr[0]);
				var top = parseInt(arr[1]);
				var width = parseInt($("#prop-" + id + " input.w").val());
				var height = parseInt($("#prop-" + id + " input.h").val());

				if(componentName == "video" || componentName == "webcontent" || componentName == "slideshow" || componentName == "gal360")
				{
					if($(this).attr("id") == "tool-" + id)
					{
						$(this).component({
							left: left,
							top: top,
							width: width,
							height: height
						});
					}
				}
				else {
					$(this).component({
						left: left,
						top: top,
						width: width,
						height: height
					});
				}
			});
			
			//Collapse init
			//initTree();
			$('div.tree').collapse(false, true);
			$('div.tree a.selectcomponent').click(function(){ cInteractivity.selectComponent($(this)); });
			
			$("#pdf-container").removeClass("loading");
			$("#page").css("display", "block");
			
			if (func && (typeof func == "function")) {
				func(obj);   
			}
		});
	}
	
	this.saveCurrentPage = function(closing)
	{
		closing = (typeof closing == "undefined") ? false : closing;
		
		var t = 'POST';
		var u = '/' + $('#currentlanguage').val() + '/' + route["interactivity_save"];
		var d = $("#pagecomponents").serialize() + "&closing=" + (closing ? 'true' : 'false');
		var ret = cInteractivity.doRequest(t, u, d);

		//asd
		var d = new Date();
		var h = (d.getHours() > 9 ? "" + d.getHours(): "0" + d.getHours());
		var m = (d.getMinutes() > 9 ? "" + d.getMinutes(): "0" + d.getMinutes());
		var s = interactivity["autosave"]
			.replace("{hour}", h)
			.replace("{minute}", m);
		
		$("#pdf-save span.save-info").html(s);

		if(!closing) {
			cInteractivity.showPage($("#pageno").val(), true);
		}
	}
	
	this.saveAndClose = function()
	{
		this.saveCurrentPage(true);
		this.close();
	}
	
	this.close = function()
	{
		closeInteractiveIDE();
	}
	
	this.exitWithoutSave = function()
	{
		this.close();
		//this.saveAndClose();
		/*
		if(confirm(interactivity["exitalert"]) == true) {
			
			this.close();
		}
		*/
	}
	
	this.hideAllInformation = function () {
		
		$("div.component-info div").addClass("hide");
    }
	
	this.selectItem = function () {
		
		$("div.component-info div").addClass("hide");
    }
}

///////////////////////////////////////////////////////////////////////////////////////
// USER
var cUser = new function () {

    this.objectName = "users";

	this.doRequest = function (t, u, d, funcError) {
		return cAjax.doSyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcError);
    }

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    }

    this.go2Login = function () {
        document.location.href = "/";
    }
	
	this.loginEvent = function (evt, func) {
        var keyCode = null;
        if (evt.which) {
            keyCode = evt.which;
        } else if (evt.keyCode) {
            keyCode = evt.keyCode;
        }
        if (13 == keyCode) {
            func();
            return false;
        }
        return true;
    }
	
	this.login = function () {
		
		cNotification.hide();
			
        var frm = $("form:first");
        var validate = cForm.validate(frm);
        if (validate) {
			
			cNotification.loader();
			
			var t = 'POST';
			var u = '/' + $('#currentlanguage').val() + '/' + route["login"];
			var d = cForm.serialize(frm);
            cUser.doAsyncRequest(t, u, d, function (ret) {
				cNotification.success(null, ret.getValue("msg"));

				document.location.href = '/' + $('#currentlanguage').val() + '/' + route["home"];
            });
        }
		else {
			cNotification.validation();
		}
    }

	this.forgotMyPassword = function () {
		
		cNotification.hide();
			
        var frm = $("form:first");
        var validate = cForm.validate(frm);
        if (validate) {
			
			cNotification.loader();
			
			var t = 'POST';
			var u = '/' + $('#currentlanguage').val() + '/' + route["forgotmypassword"];
			var d = cForm.serialize(frm);
            cUser.doAsyncRequest(t, u, d, function (ret) {
				cNotification.success(null, ret.getValue("msg"));
            });
        }
		else {
			cNotification.validation();
		}
    }
	
	this.resetMyPassword = function () {
		
		cNotification.hide();
			
        var frm = $("form:first");
        var validate = cForm.validate(frm);
        if (validate) {

			cNotification.loader();
			
			var t = 'POST';
			var u = '/' + $('#currentlanguage').val() + '/' + route["resetmypassword"];
			var d = cForm.serialize(frm);
            cUser.doAsyncRequest(t, u, d, function (ret) {
				cNotification.success(null, ret.getValue("msg"));
            });
        }
		else {
			cNotification.validation();
		}
    }
	
	this.saveMyDetail = function () {
		
		cNotification.hide();
			
        var frm = $("form:first");
        var validate = cForm.validate(frm);
		if($("#Password").val() != $("#Password2").val())
		{
			validate = false;	
		}
        if (validate) {
			
			cNotification.loader();
			
			var t = 'POST';
			var u = '/' + $('#currentlanguage').val() + '/' + route["mydetail"];
			var d = cForm.serialize(frm);
            cUser.doAsyncRequest(t, u, d, function (ret) {
				cNotification.success();
            });
        }
		else {
			cNotification.validation();
		}
    }
	
	this.save = function () {
		
		cCommon.save(this.objectName);
    }
	
	this.erase = function () {
		
		cCommon.erase(this.objectName);
	}
	
	this.sendNewPassword = function () {
		
		//if(confirm("Şifreyi sıfırlamak istediğinize emin misiniz?") == true) {
			
			cNotification.hide();
			
			var frm = $("form:first");
			var validate = cForm.validate(frm);
			if (validate) {
				
				cNotification.loader();
				
				var t = 'POST';
				var u = '/' + $('#currentlanguage').val() + '/' + route["users_send"];
				var d = cForm.serialize(frm);
				cUser.doAsyncRequest(t, u, d, function (ret) {
					cNotification.success();
				});
			}
			else {
				cNotification.validation();
			}
		//}
    }
}

///////////////////////////////////////////////////////////////////////////////////////
// CUSTOMER
var cCustomer = new function () {

    this.objectName = "customers";

	this.doRequest = function (t, u, d, funcError) {
		return cAjax.doSyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcError);
    }

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    }

	this.loadCustomerOptionList = function () {
		
		var t = 'GET';
		var u = '/' + $('#currentlanguage').val() + '/' + route["customers"];
		var d = "option=1";
		cCustomer.doAsyncRequest(t ,u ,d, function (ret) {
			$("#ddlCustomer").html(ret);
			$('#ddlCustomer').trigger('chosen:updated');
		});
    }
	
	this.CustomerOnChange = function(obj) {
		cReport.OnChange(obj);
		cApplication.loadApplicationOptionList();
	}
	
	this.save = function () {
		
		cCommon.save(this.objectName);
    }
	
	this.erase = function () {
		
		cCommon.erase(this.objectName);
	}
}

///////////////////////////////////////////////////////////////////////////////////////
// APPLICATION
var cApplication = new function () {

    this.objectName = "applications";

	this.doRequest = function (t, u, d, funcError) {
		return cAjax.doSyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcError);
    }

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    }

	this.loadApplicationOptionList = function () {

		var t = 'GET';
		var u = '/' + $('#currentlanguage').val() + '/' + route["applications"];
		var d = "customerID=" + $("#ddlCustomer").val() + "&option=1";
		cApplication.doAsyncRequest(t ,u ,d, function (ret) {
			$("#ddlApplication").html(ret);
			$('#ddlApplication').trigger('chosen:updated');
		});
    }
	
	this.ApplicationOnChange = function(obj) {
		cReport.OnChange(obj);
		cContent.loadContentOptionList();
	}
	
	this.save = function () {
		
		cCommon.save(this.objectName);
    }
	
	this.erase = function () {
		
		cCommon.erase(this.objectName);
	}

	this.pushNotification = function () {
		cNotification.hide();
		var frm = $("#formPushNotification");
		var applicationID = parseInt($("[name='ApplicationID']", frm).val());
		var url = '/' + $('#currentlanguage').val() + '/' + route["applications_pushnotification"];
		url = url.replace('(:num)', applicationID);
		var validate = cForm.validate(frm);
		if (validate) {
			cNotification.loader();
			var t = 'POST';
			var d = cForm.serialize(frm);
			cApplication.doAsyncRequest(t ,url ,d, function (ret) {
				$('#modalPushNotification').modal('hide');
				cNotification.success();
			});
		}
		else {
			cNotification.validation();
		}
	}
}

///////////////////////////////////////////////////////////////////////////////////////
// CONTENT
var cContent = new function () {

	var _self = this;

    this.objectName = "contents";

	this.doRequest = function (t, u, d, funcError) {
		return cAjax.doSyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcError);
    }

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    }
	
	this.loadContentOptionList = function () {

		var t = 'GET';
		var u = '/' + $('#currentlanguage').val() + '/' + route["contents"];
		var d = "applicationID=" + $("#ddlApplication").val() + "&option=1";
		cContent.doAsyncRequest(t ,u ,d, function (ret) {
			$("#ddlContent").html(ret);
			$('#ddlContent').trigger('chosen:updated');
		});
    }

	this.ContentOnChange = function(obj) {
		cReport.OnChange(obj);
	}
	
	this.save = function (refresh) {

		refresh = refresh ? refresh : false;
		
		//HAKAN START
		if($("#IsProtected").is(':checked')){

			var t = 'GET';
			var u = '/' + $('#currentlanguage').val() + '/' + route["contents_passwords"];
			var d = "contentID=" + $("#ContentID").val() + '&type=qty';
			var ret = cContent.doRequest(t ,u ,d);
			//console.log(ret);
			if(parseInt(ret) > 0)
				$("#Password").removeClass("required");
			else
				$("#Password").addClass("required");
		}

		if(!$('#CategoryID_chosen ul.chosen-choices li').hasClass('search-choice'))
	    {
	    	$('#dialog-category-warning').modal('show');
	    	return;
	    }
		//HAKAN END

		var fSuccess;
        if(refresh) {
        	fSuccess = function (ret) {
				//alert(ret);
				//$("input.btn").removeAttr("disabled");

				cNotification.success();
				
				document.location.href = '/' + $('#currentlanguage').val() + '/' + route[_self.objectName] + '/' + $("#ContentID").val();	
	        };
        }
		cCommon.save(this.objectName, fSuccess);
    }
	
	this.erase = function () {
		
		cCommon.erase(this.objectName);
	}
	
	this.selectFile = function () {
		
		$('#File').click();
		return false;
	}
	
	this.selectCoverImage = function () {
		
		$('#CoverImageFile').click();
		return false;
	}
	
	this.openInteractiveIDE = function (cfID) {
		
		//$(".loader").removeClass("hidden");
		cNotification.loader();
		$('#btn_interactive').addClass('on');
		/*
		var src = '/' + $("#currentlanguage").val() + '/' + route["interactivity"] + '/' + cfID;
		$("html").css("overflow", "hidden");
		
		$("iframe#interactivity")
			.attr("src", src)
			.width($(window).width())
			.height($(window).height())
			.css("display", "block")
			.load(function(){
				$(".loader").addClass("hidden");
			});
		*/
	}

	// Bu fonks. explorer 10 da iframe kapattığı için interactivity->html.blade body tagından kaldırıldı.
	this.closeInteractiveIDE = function () {
		var iframe = $("iframe#interactivity");
		if(iframe.css("display") == "block") {

			$(".loader").addClass("hidden");
		
			$("html").css("overflow", "scroll");
			
			iframe
				.attr("src", "")
				.css("display", "none");

			if(getFullscreenStatus())
			{
				exitFullscreen();	
			}

			setTimeout(function() {
			    $('#btn_interactive').removeClass('on');
			}, 2000);
		}
	}
	
	//Content category
	this.CategoryOnChange = function(obj) {
		if(obj.val() == "-1") {
			$("div.list_container").removeClass("hidden");
			$("div.cta_container").removeClass("hidden");
			$("div.form_container").addClass("hidden");
			cContent.loadCategoryList();
			$("#dialog-category-form").removeClass("hidden");
			$('#dialog-category-form').modal('show');
			//$("#dialog-category-form").dialog("open");
		}
	}
	
	this.showCategoryList = function() {
		$("div.list_container").removeClass("hidden");
		$("div.cta_container").removeClass("hidden");
		$("div.form_container").addClass("hidden");
		cContent.loadCategoryList();
		$("#dialog-category-form").removeClass("hidden");
		$('#dialog-category-form').modal('show');
		//$("#dialog-category-form").dialog("open");
	}
	
	this.loadCategoryList = function () {
		var t = 'GET';
		var u = '/' + $('#currentlanguage').val() + '/' + route["categories"];
		var d = "appID=" + $("#ApplicationID").val();
		cContent.doAsyncRequest(t ,u ,d, function (ret) {
			$("#dialog-category-form table tbody").html(ret);
		});
    }
	
	this.loadCategoryOptionList = function () {
		var t = 'GET';
		var u = '/' + $('#currentlanguage').val() + '/' + route["categories"];
		var d = "appID=" + $("#ApplicationID").val() + '&contentID=' + $("#ContentID").val() + '&type=options';
		cContent.doAsyncRequest(t ,u ,d, function (ret) {
			$("#CategoryID").html(ret);
			//$("ul.contentcategory").html(ret);
			//$("#CategoryID").trigger("liszt:updated");
			$("#CategoryID").trigger("chosen:updated");
		});
    }
	
	this.addNewCategory = function() {
		var appID = $("#ApplicationID").val();
		$("#CategoryCategoryID").val("0");
		$("#CategoryApplicationID").val(appID);
		$("#CategoryName").val("");
		$("div.list_container").addClass("hidden");
		$("div.cta_container").addClass("hidden");
		$("div.form_container").removeClass("hidden");
	}
	
	this.selectCategory = function(id) {
		$("#CategoryID").val(id);
		$("#dialog-category-form").dialog("close");
	}
	
	this.modifyCategory = function(id) {
		var appID = $("#ApplicationID").val();
		var name = $("#category" + id + " td:eq(0)").html();
		$("#CategoryCategoryID").val(id);
		$("#CategoryApplicationID").val(appID);
		$("#CategoryName").val(name);
		$("div.list_container").addClass("hidden");
		$("div.cta_container").addClass("hidden");
		$("div.form_container").removeClass("hidden");
	}
	
	this.deleteCategory = function(id) {
		//if(confirm("Silmek istediğinize emin misiniz?") == true) {

			var t = 'POST';
			var u = '/' + $('#currentlanguage').val() + '/' + route["categories_delete"];
			var d = "CategoryID=" + id;
			cContent.doAsyncRequest(t ,u ,d, function (ret) {
				cContent.loadCategoryList();					
				cContent.loadCategoryOptionList();
			});
		//}
	}
	
	this.saveCategory = function () {
		cNotification.hide();
		var frm = $("#dialog-category-form form:first");
		var validate = cForm.validate(frm);
		if (validate) {
			cNotification.loader();
			var t = 'POST';
			var u = '/' + $('#currentlanguage').val() + '/' + route["categories_save"];
			var d = cForm.serialize(frm);
			cContent.doAsyncRequest(t ,u ,d, function (ret) {
				$("div.list_container").removeClass("hidden");
				$("div.cta_container").removeClass("hidden");
				$("div.form_container").addClass("hidden");
				cContent.loadCategoryList();
				cContent.loadCategoryOptionList();
				cNotification.hide();
			});
		}
		else {
			cNotification.validation();
		}
    }

    //Content password
	this.showPasswordList = function() {
		$("div.list_container").removeClass("hidden");
		$("div.cta_container").removeClass("hidden");
		$("div.form_container").addClass("hidden");
		cContent.loadPasswordList();
		$("#dialog-password-form").removeClass("hidden");
		$('#dialog-password-form').modal('show');
		//$("#dialog-password-form").dialog("open");
	}
	
	this.loadPasswordList = function () {
		var t = 'GET';
		var u = '/' + $('#currentlanguage').val() + '/' + route["contents_passwords"];
		var d = "contentID=" + $("#ContentID").val();
		cContent.doAsyncRequest(t ,u ,d, function (ret) {
			$("#dialog-password-form table tbody").html(ret);
		});
    }
	
	this.addNewPassword = function() {
		var contentID = $("#ContentID").val();
		$("#ContentPasswordID").val("0");
		$("#ContentPasswordContentID").val(contentID);
		$("#ContentPasswordName").val("");
		$("#ContentPasswordPassword").val("");
		$("#ContentPasswordQty").val("1");
		$("div.list_container").addClass("hidden");
		$("div.cta_container").addClass("hidden");
		$("div.form_container").removeClass("hidden");
	}
	
	this.modifyPassword = function(id) {
		var contentID = $("#ContentID").val();
		var name = $("#contentpassword" + id + " td:eq(0)").html();
		var qty = $("#contentpassword" + id + " td:eq(1)").html();
		$("#ContentPasswordID").val(id);
		$("#ContentPasswordContentID").val(contentID);
		$("#ContentPasswordName").val(name);
		$("#ContentPasswordPassword").val("");
		$("#ContentPasswordQty").val(qty);
		$("div.list_container").addClass("hidden");
		$("div.cta_container").addClass("hidden");
		$("div.form_container").removeClass("hidden");
	}
	
	this.deletePassword = function(id) {
		//if(confirm("Silmek istediğinize emin misiniz?") == true) {

			var t = 'POST';
			var u = '/' + $('#currentlanguage').val() + '/' + route["contents_passwords_delete"];
			var d = "ContentPasswordID=" + id;
			cContent.doAsyncRequest(t ,u ,d, function (ret) {
				cContent.loadPasswordList();
			});
		//}
	}
	
	this.savePassword = function () {
		cNotification.hide();
		var frm = $("#dialog-password-form form:first");
		var validate = cForm.validate(frm);
		if (validate) {
			cNotification.loader();
			var t = 'POST';
			var u = '/' + $('#currentlanguage').val() + '/' + route["contents_passwords_save"];
			var d = cForm.serialize(frm);
			cContent.doAsyncRequest(t ,u ,d, function (ret) {
				$("div.list_container").removeClass("hidden");
				$("div.cta_container").removeClass("hidden");
				$("div.form_container").addClass("hidden");
				cContent.loadPasswordList();
				cNotification.hide();
			});
		}
		else {
			cNotification.validation();
		}
    }

	this.giveup = function() {
		
		$("div.list_container").removeClass("hidden");
		$("div.cta_container").removeClass("hidden");
		$("div.form_container").addClass("hidden");
	}
}

///////////////////////////////////////////////////////////////////////////////////////
// ORDER
var cOrder = new function () {

    this.objectName = "orders";

	this.doRequest = function (t, u, d, funcError) {
		return cAjax.doSyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcError);
    }

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    }
	
	this.save = function () {
		
		cCommon.save(this.objectName);
    }
	
	this.erase = function () {
		
		cCommon.erase(this.objectName);
	}
}

///////////////////////////////////////////////////////////////////////////////////////
// REPORT
var cReport = new function () {
	
	this.objectName = "reports";
	
	this.doRequest = function (t, u, d, funcError) {
		return cAjax.doSyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcError);
    }

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    }
	
	this.getParameters = function() {
		var param = "";
		param = param + "&sd=" + $("#start-date").val();
		param = param + "&ed=" + $("#end-date").val();
		param = param + "&customerID=" + $("#ddlCustomer").val();
		param = param + "&applicationID=" + $("#ddlApplication").val();
		param = param + "&contentID=" + $("#ddlContent").val();
		param = param + "&country=" + $("#ddlCountry").val();
		param = param + "&city=" + $("#ddlCity").val();
		param = param + "&district=" + $("#ddlDistrict").val();
		return param;
	}
	
	this.CountryOnChange = function(obj) {
		cReport.loadCityOptionList();
	}

	this.CityOnChange = function(obj) {
		cReport.loadDistrictOptionList();
	}

	this.loadCountryOptionList = function () {
		var t = 'GET';
		var u = '/' + $('#currentlanguage').val() + '/' + route["reports_location_country"];
		var d = "customerID=" + $("#ddlCustomer").val() + "&applicationID=" + $("#ddlApplication").val() + "&contentID=" + $("#ddlContent").val();
		cReport.doAsyncRequest(t, u, d, function (ret) {
			$("#ddlCountry").html(ret);
			$('#ddlCountry').change();
			$('#ddlCountry').trigger('chosen:updated');
		});
    }

	this.loadCityOptionList = function () {
		var t = 'GET';
		var u = '/' + $('#currentlanguage').val() + '/' + route["reports_location_city"];
		var d = "customerID=" + $("#ddlCustomer").val() + "&applicationID=" + $("#ddlApplication").val() + "&contentID=" + $("#ddlContent").val() + "&country=" + $("#ddlCountry").val();
		cReport.doAsyncRequest(t, u, d, function (ret) {
			$("#ddlCity").html(ret);
			$('#ddlCity').change();
			$('#ddlCity').trigger('chosen:updated');
		});
    }

    this.loadDistrictOptionList = function () {
		var t = 'GET';
		var u = '/' + $('#currentlanguage').val() + '/' + route["reports_location_district"];
		var d = "customerID=" + $("#ddlCustomer").val() + "&applicationID=" + $("#ddlApplication").val() + "&contentID=" + $("#ddlContent").val() + "&country=" + $("#ddlCountry").val() + "&city=" + $("#ddlCity").val();
		cReport.doAsyncRequest(t, u, d, function (ret) {
			$("#ddlDistrict").html(ret);
			$('#ddlDistrict').trigger('chosen:updated');
		});
    }

	this.OnChange = function(obj) {
		var param = this.getParameters();
		
		$("a.report-button").each(function(){
			
			var baseAddress = $(this).attr("baseAddress");
			
			$(this).attr("href", baseAddress + param);
		});
	}
	
	this.refreshReport = function() {
		var param = this.getParameters();
		var url = "/" + $('#currentlanguage').val() + "/" + route["reports"] + "/" + $("#report").val() + "?dummy=1" + param;
		this.setIframeUrl(url);
		//$('#myLoaderStatusBar').removeClass('hidden');
		//$('#myLoaderStatusBar').css('display','block');
		cNotification.loader();
	}
	
	this.downloadAsExcel = function() {
		var param = this.getParameters();
		window.open("/" + $('#currentlanguage').val() + "/" + route["reports"] + "/" + $("#report").val() + "?xls=1" + param);
	}

	this.viewOnMap = function() {
		var param = this.getParameters();
		var url = "/" + $('#currentlanguage').val() + "/" + route["reports"] + "/" + $("#report").val() + "?map=1" + param;
		this.setIframeUrl(url);
	}

	this.setIframeUrl = function(src) {
		$("iframe").load(function() {
			var h = $(this).contents().find('body').height() + 30;
			$(this).height(h);
			cNotification.element.removeClass('statusbar-loader');
		}).attr("src", src);
	}
}

///////////////////////////////////////////////////////////////////////////////////////
// COMMON
var cCommon = new function () {

	this.doRequest = function (t, u, d, funcError) {
		return cAjax.doSyncRequest(t, u, d, funcError);
    }

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, d, funcSuccess, funcError, true);
    }
	
	this.save = function (param, fSuccess) {

		//goToList = goToList ? goToList : true;
		if(typeof fSuccess !== 'function') {
			fSuccess = function (ret) {
				//alert(ret);
				//$("input.btn").removeAttr("disabled");

				cNotification.success();
				
				var qs = cCommon.getQS();
				document.location.href = '/' + $('#currentlanguage').val() + '/' + route[param] + qs;	
            };
		}

		cNotification.hide();
		//$("input.btn").attr("disabled", "disabled");

        var frm = $("form:first");
        var validate = cForm.validate(frm);
        if (validate) {
			
			cNotification.loader();
			
			var t = 'POST';
			var u = '/' + $('#currentlanguage').val() + '/' + route[param + "_save"];
			var d = cForm.serialize(frm);
            cCommon.doAsyncRequest(t, u, d, fSuccess);

            //Error
            //$("input.btn").removeAttr("disabled");
        }
		else {
			//$("input.btn").removeAttr("disabled");
			cNotification.validation();
		}
    }
	
	this.erase = function (param) {
		
		//if(confirm("Silmek istediğinize emin misiniz?") == true) {
			
			cNotification.hide();
			cNotification.loader();

	        var frm = $("form:first");
			var t = 'POST';
			var u = '/' + $('#currentlanguage').val() + '/' + route[param + "_delete"];
			var d = cForm.serialize(frm);
            cCommon.doAsyncRequest(t, u, d, function (ret) {
				cNotification.success();
				var qs = cCommon.getQS();
				document.location.href = '/' + $('#currentlanguage').val() + '/' + route[param] + qs;
            });
		//}
	}
	
	this.getQS = function () {
		
		var qs = "";
		var customerID = "";
		var applicationID = "";
		var url = document.location.href;
		
		//kullanici ve uygulama listesinde customerID olabilir
		if(url.indexOf(route["users"]) > -1 || url.indexOf(route["applications"]) > -1)
		{
			customerID = getParameterByName("customerID");
			if(customerID.length > 0) {
				qs = qs + (qs.length > 0 ? "&" : "?") + "customerID=" + customerID;
			}
			else
			{
				customerID = $("#CustomerID").val();
				if(customerID !== undefined && customerID.length > 0) {
					qs = qs + (qs.length > 0 ? "&" : "?") + "customerID=" + customerID;
				}	
			}	
		}
		
		//icerik listesinde applicationID olabilir
		if(url.indexOf(route["contents"]) > -1)
		{
			applicationID = getParameterByName("applicationID");
			if(applicationID.length > 0) {
				qs = qs + (qs.length > 0 ? "&" : "?") + "applicationID=" + applicationID;
			}
			else 
			{
				applicationID = $("#ApplicationID").val();
				if(applicationID !== undefined && applicationID.length > 0) {
					qs = qs + (qs.length > 0 ? "&" : "?") + "applicationID=" + applicationID;
				}
			}
		}
		return qs;
	}
}

///////////////////////////////////////////////////////////////////////////////////////
// NOTIFICATION
var cNotification = new function () {
	
	var _self = this;

	this.element = null;

	$(function () {
		_self.element = $("#myNotification");
	});

	this.validation = function (text, detail) {
		text = text ? text : notification["validation"];
		this.setClass("statusbar-warning");
		this.element.find("div.statusbar-icon span").removeAttr("class").addClass("icon-warning-sign");
		this.hideTexts(text, detail);
		this.show();
	};
	
	this.info = function (text, detail) {
		this.setClass("statusbar-info");
		this.element.find("div.statusbar-icon span").removeAttr("class").addClass("icon-info");
		this.hideTexts(text, detail);
		this.show();
	};

	this.loader = function (text, detail) {
		text = text ? text : notification["loading"];
		this.setClass("statusbar-loader");
		//this.element.find("div.statusbar-icon span").removeAttr("class").addClass("icon-spinner spinner");
		this.element.find("div.statusbar-icon span").removeAttr("class");
		this.hideTexts(text, detail);
		this.show();

		if(this.element.find('#galeSpinner').length == 0)
		{
			this.element.prepend("<img src='/img/galeLogo.png' id='galeSpinner' style='position:absolute;left:10px;'>");
		}
		this.element.find('#galeSpinner').removeClass();
		this.element.find('#galeSpinner').hide();
		this.element.find('#galeSpinner').show('scale', { percent: 100 }, 600);

		function animateRotate(start,end,duration,easingEffect){
			var object = _self.element.find('#galeSpinner');
			$({deg: start}).animate({deg: end},{
				duration: duration,
				easing: easingEffect,
				step: function(now){
					object.css({
						'-webkit-transform': "rotate(" + now + "deg)"
					}).css({
						'-moz-transform': "rotate(" + now + "deg)"
					}).css({
						'-ms-transform': "rotate(" + now + "deg)"
					}).css({
						'transform': "rotate(" + now + "deg)"
					});
				},
		        complete: function(){
		        	if(_self.element.hasClass("statusbar-loader"))
					{
		        		animateRotate(0,1800,900,'linear');
		        	}
		        	else if(!object.hasClass('stopAnimeOne')) {
	        			animateRotate(0,720,1000,'easeOutQuint');
	        			object.addClass('stopAnimeOne');
	        			if(!_self.element.hasClass("statusbar-danger")) {
		        			setTimeout(function(){
								_self.hide(500);
							},1500);	
	        			}
			   		}
				}
			});
		}
		animateRotate(0,1800,1200,'easeInCubic');
	};

	this.success = function (text, detail) {
		text = text ? text : notification["success"];
		this.setClass("statusbar-success");
		this.element.find("div.statusbar-icon span").removeAttr("class").addClass("icon-ok");
		this.hideTexts(text, detail);
		this.show();
	};

	this.failure = function (text, detail) {
		text = text ? text : notification["failure"];
		this.setClass("statusbar-danger");
		this.element.find("div.statusbar-icon span").removeAttr("class").addClass("icon-remove");
		this.hideTexts(text, detail);
		this.show();
	};

	this.show = function () {
		if(!(this.element.hasClass("statusbar-loader") || this.element.hasClass("statusbar-success") || this.element.hasClass("statusbar-danger")) && this.element.find('#galeSpinner').length > 0) {
			this.element.find("#galeSpinner").remove();   
		}
		this.hide();
		//this.element.fadeIn();
		//this.element.removeClass("hidden");
		this.element.show();
	};

	this.hide = function (v) {
		v = v ? v : 0;
		//this.element.addClass("hidden");
		this.element.hide(v);
	};

	this.setClass = function (c) {
		this.element.removeAttr("class").addClass("statusbar").addClass(c);
	};

	this.hideTexts = function (text, detail) {
		text = text ? text : '';
		detail = detail ? detail : '';
		this.element.find("div.statusbar-text span.text").html(text);
		this.element.find("div.statusbar-text span.detail").html(detail);
	};
}

///////////////////////////////////////////////////////////////////////////////////////
// AJAX
var cAjax = new function () {

    this.doSyncRequest = function (t, u, d, funcError) {
    	
    	updatePageRequestTime();

    	if(typeof funcError === "undefined") {
    		funcError = function (ret) {
				cNotification.failure(ret.getValue("errmsg"));
			};
    	}

        return $.ajax({
            async: false,
            type: t,
            url: u,
            data: d,
            error: funcError
        }).responseText;
    }

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError, checkIfUserLoggedIn) {
    	
		updatePageRequestTime();

		if(typeof funcError === "undefined") {
    		funcError = function (ret) {
				cNotification.failure(ret.getValue("errmsg"));
			};
    	}
        checkIfUserLoggedIn = (typeof checkIfUserLoggedIn === "undefined") ? true : false;

        $.ajax
        ({
	        type: t,
	        url: u,
	        data: d,
	        success: function (ret) {

	        	if(t === 'GET') {
	        		
					funcSuccess(ret);
	        		return;
	        	}

	            if (checkIfUserLoggedIn) {

	                if (ret.getValue("userLoggedIn") == "true") {
						
						if (ret.getValue("success") == "true") {

							funcSuccess(ret);
						}
						else {
							funcError(ret);
						}
						return;
	                }
	                cUser.go2Login();
	            }
	            else {
					if (ret.getValue("success") == "true") {

						funcSuccess(ret);
					}
					else {
						funcError(ret);
					}
	            }
	        },
	        error: funcError
	    });
    }
}

///////////////////////////////////////////////////////////////////////////////////////
// FORM
var cForm = new function () {

    this.validate = function (formObj) {

        var ret = true;

        formObj.each(function () {

            $("div.error", $(this)).removeClass("error");

			$(".required", $(this)).each(function () {

				//if ($(this).val().length == 0) {
				if (!$(this).val()) {

					ret = false;
					
					$(this).prev().addClass("error");
					$(this).parent().prev().addClass("error");
				}
			});
        });
        return ret;
    }

    this.serialize = function (formObj) {

        var ret = "";

        formObj.each(function () {

            if ($(this).is("form")) {

                ret = ret + "&" + $(this).serialize();
            }
        });
        return ret;
    }
}

///////////////////////////////////////////////////////////////////////////////////////
// MODALFORM
var modalform = new function () {

    var modalForm;
    var contentContainer;

    this.show = function (c) {

        this.modalForm = c;

        this.contentContainer = $(".modalformcontainer", this.modalForm);
        this.contentContainer.html('<div class="loader"></div>');
        this.modalForm.removeClass("hidden");
        this.reposition();

        //show overlay window
        var overlay;
        if ($(".ui-widget-overlay").size() > 0) {

            overlay = $(".ui-widget-overlay");
        }
        else {
			$('<div></div>')
				.addClass('ui-widget-overlay')
				.addClass('hidden')
				.css("z-index", "1001")
				.appendTo("body");

            overlay = $(".ui-widget-overlay");
        }

        overlay
            .css("width", $(document).width())
            .css("height", $(document).height())
            .removeClass("hidden");
    }

    this.reposition = function () {
        var t = $(window).scrollTop() + (($(window).height() - this.modalForm.height()) / 2);
        var l = ($(window).width() - this.modalForm.width()) / 2;

        /*
        if (this.modalForm.hasClass("modalform")) {

        l = (($(window).width() - this.modalForm.width()) / 2) - $("#content").offset().left;
        }
        */
        //console.log("window height = " + $(window).height() + " modal height = " + this.modalForm.height() + " top = " + t);
        this.modalForm.css({
            left: l + "px",
            top: t + "px"
        });
    }

    this.content = function (c) {
        this.contentContainer.html(c);
        this.reposition();
    }

    this.close = function () {
        this.modalForm.addClass("hidden");
        $(".ui-widget-overlay").addClass("hidden");
    }
}