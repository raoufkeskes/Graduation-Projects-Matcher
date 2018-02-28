
var form = $( "#form1" );




 jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});

jQuery.extend
(
  jQuery.validator.messages,
  {
    required: "Ce champs est obligatoire", 
    maxlength: jQuery.validator.format("Ce champs ne doit pas contenir plus de {0} caractères."),
  }
)


jQuery.validator.addMethod
(
      "regex",
      function(value, element, regexp)
      {
          var re = new RegExp(regexp);
          return this.optional(element) || re.test(value);
      },
      "Ce champs ne doit contenir que des lettres et des espaces."
);





form.validate
(
    {
       rules: 
        {
           
            nom: 
            {
                required:true,
                maxlength:50,
                regex: "^[À-ÿa-zA-Z'.\\s]+$",

            },
            prenom: 
            {
                required:true,
                maxlength:50,
                regex: "^[À-ÿa-zA-Z'.\\s]+$"
            },
            service: 
            {
                required:true,
                maxlength:80,
                regex:  "^[À-ÿa-zA-Z'.\\s]+$"
            },
            grade: 
            {
                required:true,
                maxlength:30,
                regex: "^[À-ÿa-zA-Z'.\\s]+$"
            },
            profession: 
            {
                required:true,
                maxlength:30,
                regex: "^[À-ÿa-zA-Z'.\\s]+$"
            } ,

           
  
  
        }
        
    }
) ;

//End employee form validation










 







