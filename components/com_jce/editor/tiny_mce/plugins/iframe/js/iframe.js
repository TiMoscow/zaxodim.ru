/* jce - 2.7.18 | 2019-09-26 | https://www.joomlacontenteditor.net | Copyright (C) 2006 - 2019 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
var IframeDialog={settings:{},init:function(){var v,self=this,ed=tinyMCEPopup.editor,s=ed.selection,n=s.getNode(),data={};if(tinyMCEPopup.restoreSelection(),TinyMCE_Utils.fillClassList("classlist"),Wf.init(),this.settings.file_browser&&Wf.createBrowsers($("#src"),function(files,data){file=data[0],$("#src").val(file.url),file.width&&$("#width").val(file.width).data("tmp",file.width).change(),file.height&&$("#height").val(file.height).data("tmp",file.height).change()}),$("#insert").click(function(){self.insert()}),$("#src").change(function(){var data={},v=this.value;(s=WFAggregator.isSupported(v))?(data=WFAggregator.getAttributes(s,v),$(".aggregator_option, .options_description","#options_tab").hide().filter("."+s).show()):$(".options_description","#options_tab").show();for(n in data){var $el=$("#"+n),v=data[n];"width"==n||"height"==n?""!==$el.val()&&$el.hasClass("edited")!==!1||$("#"+n).val(data[n]).data("tmp",data[n]).change():$el.is(":checkbox")?(v=parseInt(v),$el.attr("checked",v).prop("checked",v)):$el.val(v)}}),/mce-item-iframe/.test(n.className)){if(data=$.parseJSON(ed.dom.getAttrib(n,"data-mce-json")),data&&data.iframe){$(".uk-button-text","#insert").text(tinyMCEPopup.getLang("update","Update",!0)),data=data.iframe,$.each(data,function(k,v){"scrolling"===k&&"auto"===v&&(v=""),$("#"+k).is(":checkbox")?$("#"+k).prop("checked",!!v):("src"==k&&(v=ed.convertURL(v)),$("#"+k).val(v).change())}),$.each(["class","width","height","id","longdesc","align"],function(i,k){switch(v=ed.dom.getAttrib(n,k),k){case"class":v=tinymce.trim(v.replace(/mce-item-(\w+)/gi,"").replace(/\s+/g," ")),$("#classes, #classlist").val(v);break;case"width":case"height":v=parseFloat(ed.dom.getAttrib(n,k)||ed.dom.getStyle(n,k))||"",$("#"+k).val(v).data("tmp",v).change();break;case"align":$("#"+k).val(self.getAttrib(n,k));break;default:$("#"+k).val(v)}});var style=ed.dom.parseStyle(ed.dom.getAttrib(n,"style"));tinymce.each(["top","right","bottom","left"],function(pos){var val=self.getAttrib(n,"margin-"+pos);$("#margin_"+pos).val(val),delete style["margin-"+pos]}),delete style.width,delete style.height,$("#style").val(ed.dom.serializeStyle(style))}}else Wf.setDefaults(this.settings.defaults);WFAggregator.setup({embed:!1}),$(".uk-equalize-checkbox").trigger("equalize:update")},getAttrib:function(e,at){return Wf.getAttrib(e,at)},checkPrefix:function(n){var self=this,v=$(n).val();/^\s*www./i.test(v)?Wf.Modal.confirm(tinyMCEPopup.getLang("iframe_dlg.is_external","The URL you entered seems to be an external link, do you want to add the required http:// prefix?"),function(state){state&&$(n).val("http://"+v),self.insert()}):this.insertAndClose()},insert:function(){tinyMCEPopup.editor;return""===$("#src").val()?(Wf.Modal.alert(tinyMCEPopup.getLang("iframe_dlg.no_src","Please enter a url for the iframe")),!1):""===$("#width").val()||""===$("#height").val()?(Wf.Modal.alert(tinyMCEPopup.getLang("iframe_dlg.no_dimensions","Please enter a width and height for the iframe")),!1):this.checkPrefix($("#src"))},insertAndClose:function(){tinyMCEPopup.restoreSelection();var ed=tinyMCEPopup.editor,args={},n=ed.selection.getNode(),attribs=this.getParameters();tinymce.each(["style","id","longdesc","title"],function(k){args[k]=$("#"+k).val()});var w=$("#width").val()||384,h=$("#height").val()||216;if(tinymce.extend(args,{"data-mce-json":this.serializeParameters(),"data-mce-width":w,"data-mce-height":h}),n&&ed.dom.is(n,".mce-item-iframe")){ed.dom.setAttribs(n,args),ed.dom.setStyles(n,{width:w,height:h});var cls="mce-item-media mce-item-iframe "+$("#classes").val();ed.dom.setAttrib(n,"class",$.trim(cls))}else{var html="<iframe";attribs.width=w,attribs.height=h,attribs.class=$("#classes").val(),tinymce.each(attribs,function(v,k){return"html"===k||void(""!==v&&tinymce.is(v)&&(html+=" "+k+'="'+v+'"'))});var innerHTML=$("#html").val();html+=">"+$.trim(innerHTML)+"</iframe>",ed.execCommand("mceInsertContent",!1,html,{skip_undo:1}),ed.undoManager.add()}tinyMCEPopup.close()},getParameters:function(){var s,v,ed=tinyMCEPopup.editor,data={};return tinymce.each(["src","name","scrolling","frameborder","allowtransparency","allowfullscreen","html"],function(k){if(!$("#"+k).prop("disabled")&&(v=$("#"+k).is(":checkbox")?$("#"+k).is(":checked")?1:0:$("#"+k).val(),""!==v)){if("src"==k&&(v=v.replace(/&amp;/gi,"&"),v=ed.convertURL(v)),"html4"!==ed.settings.schema&&"frameborder"===k)return!0;"scrolling"===k&&"auto"===v&&(v=null),null!==v&&(data[k]=v)}}),(s=WFAggregator.isSupported(data.src))&&$.extend(!0,data,WFAggregator.getValues(s,data.src)),data},serializeParameters:function(){var o={iframe:this.getParameters()};return JSON.stringify(o)}};tinyMCEPopup.onInit.add(IframeDialog.init,IframeDialog);