(function($) {
  
   if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
   CKEDITOR.tools.enableHtml5Elements( document );
   CKEDITOR.config.height = 100;
   CKEDITOR.config.width = 'auto';
  var initSample2 = ( function() {
   var wysiwygareaAvailable = isWysiwygareaAvailable(),
       isBBCodeBuiltIn = !!CKEDITOR.plugins.get( 'bbcode' );

   return function() {
       var dd=1;
       $(".ckeditor").each(function(){
           var id = $(this).attr("id");//alert(id);
           if(id){
               var editorElement = CKEDITOR.document.getById( id);//console.log(editorElement);

               if ( isBBCodeBuiltIn ) {
                   editorElement.setHtml(
                       'Hello world!\n\n' +
                       'I\'m an instance of [url=http://ckeditor.com]CKEditor[/url].'
                   );
               }

               // Depending on the wysiwygare plugin availability initialize classic or inline editor.
               if ( wysiwygareaAvailable ) {
                   CKEDITOR.replace(id);
                   dd=dd+1;
               } else {
                   editorElement.setAttribute( 'contenteditable', 'true' );
                   CKEDITOR.inline(id);
                   
               }
           }
       });
   };

   function isWysiwygareaAvailable() {
       if ( CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
           return true;
       }

       return !!CKEDITOR.plugins.get( 'wysiwygarea' );
   }
} )();

})(jQuery);