/**
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
**/
var tinymce,tinyMCE,tinyMCEPopup={init:function(){var win,self=this;win=this.getWin(),tinymce=tinyMCE=win.tinymce,this.editor=tinymce.EditorManager.activeEditor,this.params=this.editor.windowManager.params,this.features=this.editor.windowManager.features,this.dom=this.editor.windowManager.createInstance("tinymce.dom.DOMUtils",document,{ownEvents:!0,proxy:tinyMCEPopup._eventProxy}),this.dom.bind(window,"ready",this._onDOMLoaded,this),this.features.popup_css!==!1&&this.dom.loadCSS(this.features.popup_css||this.editor.settings.popup_css),this.listeners=[],this.onInit={add:function(fn,scope){self.listeners.push({func:fn,scope:scope})}},this.isWindow=!1,this.id=this.getWindowArg("mce_window_id"),this.editor.windowManager.onOpen.dispatch(this.editor.windowManager,window)},getWin:function(){return!window.frameElement&&window.dialogArguments||opener||parent||top},getWindowArg:function(name,defaultValue){var value=this.params[name];return tinymce.is(value)?value:defaultValue},getParam:function(name,defaultValue){return this.editor.getParam(name,defaultValue)},getLang:function(name,defaultValue){return this.editor.getLang(name,defaultValue)},execCommand:function(cmd,ui,val,a){return a=a||{},a.skip_focus=1,this.restoreSelection(),this.editor.execCommand(cmd,ui,val,a)},resizeToInnerSize:function(){var self=this,editor=this.editor,dom=this.dom;setTimeout(function(){var vp=dom.getViewPort(window);editor.windowManager.resizeBy(self.getWindowArg("mce_width")-vp.win,self.getWindowArg("mce_height")-vp.h,self.id||window)},10)},storeSelection:function(){this.editor.windowManager.bookmark=tinyMCEPopup.editor.selection.getBookmark(1)},restoreSelection:function(){!this.isWindow&&tinymce.isIE&&this.editor.selection.moveToBookmark(this.editor.windowManager.bookmark)},pickColor:function(e,element_id){this.execCommand("mceColorPicker",!0,{color:document.getElementById(element_id).value,func:function(color){document.getElementById(element_id).value=color;try{document.getElementById(element_id).onchange()}catch(ex){}}})},openBrowser:function(args){tinyMCEPopup.restoreSelection(),this.editor.execCallback("file_browser_callback",args,window)},confirm:function(title,callback,scope){this.editor.windowManager.confirm(title,callback,scope,window)},alert:function(title,callback,scope){this.editor.windowManager.alert(title,callback,scope,window)},close:function(){this.editor.windowManager.close(window),tinymce=tinyMCE=this.editor=this.params=this.dom=this.dom.doc=null},_restoreSelection:function(e){e=e&&e.target||window.event.srcElement,"INPUT"!=e.nodeName||"submit"!=e.type&&"button"!=e.type||tinyMCEPopup.restoreSelection()},_onDOMLoaded:function(){var editor=this.editor,dom=this.dom,title=document.title;editor.getParam("browser_preferred_colors",!1)&&this.isWindow||dom.addClass(document.body,"forceColors"),document.body.style.display="",tinymce.isIE&&document.addEventListener("mouseup",tinyMCEPopup._restoreSelection,!1),this.restoreSelection(),this.resizeToInnerSize(),this.isWindow?window.focus():editor.windowManager.setTitle(window,title),tinymce.isIE||this.isWindow||dom.bind(document,"focus",function(){editor.windowManager.focus(this.id)}),tinymce.each(dom.select("select"),function(e){e.onkeydown=tinyMCEPopup._accessHandler}),tinymce.each(this.listeners,function(o){o.func.call(o.scope,editor)}),this.getWindowArg("mce_auto_focus",!0)&&(window.focus(),tinymce.each(document.forms,function(f){tinymce.each(f.elements,function(e){if(dom.hasClass(e,"mceFocus")&&!e.disabled)return e.focus(),!1})})),document.onkeyup=tinyMCEPopup._closeWinKeyHandler},_accessHandler:function(e){if(e=e||window.event,13==e.keyCode||32==e.keyCode){var elm=e.target||e.srcElement;return elm.onchange&&elm.onchange(),tinymce.dom.Event.cancel(e)}},_closeWinKeyHandler:function(e){e=e||window.event,27==e.keyCode&&tinyMCEPopup.close()},_eventProxy:function(id){return function(evt){tinyMCEPopup.dom.events.callNativeHandler(id,evt)}}};tinyMCEPopup.init();