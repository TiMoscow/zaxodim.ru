/* jce - 2.7.18 | 2019-09-26 | https://www.joomlacontenteditor.net | Copyright (C) 2006 - 2019 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
!function(){tinymce.each,tinymce.dom.Event;tinymce.create("tinymce.plugins.ImageManagerExtended",{init:function(ed,url){function isMceItem(n){var cls=ed.dom.getAttrib(n,"class","");return/mce-item-/.test(cls)}this.editor=ed,this.url=url,ed.onPreInit.add(function(){ed.parser.addNodeFilter("img",function(nodes){for(var node,i=nodes.length;i--;){node=nodes[i];var src=node.attr("src");if(src&&src.indexOf("?")===-1&&/\.(jpg|jpeg|png)$/.test(src)){var stamp="?"+(new Date).getTime();src=ed.convertURL(src,"src",node.name),node.attr("src",src+stamp),node.attr("data-mce-src",src)}}})}),ed.addCommand("mceImageManagerExtended",function(){var n=ed.selection.getNode();"IMG"==n.nodeName&&isMceItem(n)||ed.windowManager.open({file:ed.getParam("site_url")+"index.php?option=com_jce&task=plugin.display&plugin=imagepro",width:780+ed.getLang("imgmanager_ext.delta_width",0),height:700+ed.getLang("imgmanager_ext.delta_height",0),inline:1,popup_css:!1,size:"mce-modal-portrait-full"},{plugin_url:url})}),ed.addButton("imgmanager_ext",{title:"imgmanager_ext.desc",cmd:"mceImageManagerExtended"}),ed.onNodeChange.add(function(ed,cm,n){cm.setActive("imgmanager_ext","IMG"==n.nodeName&&!isMceItem(n))}),ed.onInit.add(function(){ed&&ed.plugins.contextmenu&&ed.plugins.contextmenu.onContextMenu.add(function(th,m,e){m.add({title:"imgmanager_ext.desc",icon:"imgmanager_ext",cmd:"mceImageManagerExtended"})})})},insertUploadedFile:function(o){var ed=this.editor,data=this.getUploadConfig();if(data&&data.filetypes&&new RegExp(".("+data.filetypes.join("|")+")$","i").test(o.file)){var args={src:o.file,alt:o.alt||o.name,style:{}},attribs=["alt","title","id","dir","class","usemap","style","longdesc"];if(o.styles){var s=ed.dom.parseStyle(ed.dom.serializeStyle(o.styles));tinymce.extend(args.style,s),delete o.styles}if(o.style){var s=ed.dom.parseStyle(o.style);tinymce.extend(args.style,s),delete o.style}return tinymce.each(attribs,function(k){"undefined"!=typeof o[k]&&(args[k]=o[k])}),ed.dom.create("img",args)}return!1},getUploadURL:function(file){var ed=this.editor,data=this.getUploadConfig();return!!(data&&data.filetypes&&new RegExp(".("+data.filetypes.join("|")+")$","i").test(file.name))&&ed.getParam("site_url")+"index.php?option=com_jce&task=plugin.display&plugin=imagepro"},getUploadConfig:function(){var ed=this.editor,data=ed.getParam("imgmanager_ext_upload");return data}}),tinymce.PluginManager.add("imgmanager_ext",tinymce.plugins.ImageManagerExtended)}();