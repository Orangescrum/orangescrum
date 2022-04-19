/*!
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <jevin9@gmail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Jevin O. Sewaruth
 * ----------------------------------------------------------------------------
 *
 * Autogrow Textarea Plugin Version v3.0
 * http://www.technoreply.com/autogrow-textarea-plugin-3-0
 * 
 * THIS PLUGIN IS DELIVERD ON A PAY WHAT YOU WHANT BASIS. IF THE PLUGIN WAS USEFUL TO YOU, PLEASE CONSIDER BUYING THE PLUGIN HERE :
 * https://sites.fastspring.com/technoreply/instant/autogrowtextareaplugin
 *
 * Date: October 15, 2012
 */
;jQuery.fn.autoGrow=function(a){return this.each(function(){var d=jQuery.extend({extraLine:true},a);var e=function(g){jQuery(g).after('<div class="autogrow-textarea-mirror"></div>');return jQuery(g).next(".autogrow-textarea-mirror")[0]};var b=function(g){f.innerHTML=String(g.value).replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/'/g,"&#39;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/ /g,"&nbsp;").replace(/\n/g,"<br />")+(d.extraLine?".<br/>.":"");if(jQuery(g).height()!=jQuery(f).height()){jQuery(g).height(jQuery(f).height())}};var c=function(){b(this)};var f=e(this);f.style.display="none";f.style.wordWrap="break-word";f.style.whiteSpace="normal";f.style.padding=jQuery(this).css("padding");f.style.width=jQuery(this).css("width");f.style.fontFamily=jQuery(this).css("font-family");f.style.fontSize=jQuery(this).css("font-size");f.style.lineHeight=jQuery(this).css("line-height");this.style.overflow="hidden";this.style.minHeight=this.rows+"em";this.onkeyup=c;b(this)})};