$(document).ready(function () {

     // Define custom validation method for file extension
     $.validator.addMethod("extension", function (value, element, param) {
       var allowedExtensions = param.split('|');
       var fileExtension = value.split('.').pop().toLowerCase();
       return this.optional(element) || $.inArray(fileExtension, allowedExtensions) !== -1;
   }, 'Invalid file type.');
   
   // Define custom validation method for image required
   $.validator.addMethod("requiredFile", function (value, element) {
       return $(element).val() !== '';
   }, 'Please select profile picture.');
   
    //Validation for add,update Category form
       $('#categoryForm').validate({
           rules: {
               category_name: {
                   required: true
               }
           },
           messages: {
            category_name: 
               {
                   required:'Please enter Category Name.'
               },
           },
           submitHandler: function (form) {
               form.submit();
           }
       });
   
    //Validation for profile form
   $('#profileForm').validate({
       rules: {
           full_name: {
               required: true,
               pattern: /^[A-Za-z]/ 
           },
           email: {
               required: true,
               email: true
           }
          
       },
       messages: {
           full_name: 
           {
               required:'Please enter FullName.',
                pattern: 'Only letters are allowed.'
           },
   
           email: {
               required: 'Please enter Email Address.',
               email: 'Please enter a valid Email Address.',
           }
          
       },
       submitHandler: function (form) {
           form.submit();
       }
   });
   
    //Validation for add,edit Blog form
   $('#blogForm').validate({
       rules: {
           category: {
               required: true
           },
           title: {
               required: true,     
           },
           blog_image: {
               required: true,
               extension: "jpg|jpeg|png"
           },
           content: {
               required: true,
               minlength: 10
           }
       },
       messages: {
           category: {
               required: 'Please select a category.'
           },
           title: {
               required: 'Please enter the title.',           
           },
           blog_image: {
               required: 'Please select an image.',
               extension: 'Only JPG, JPEG, and PNG images are allowed.'
           },
           content: {
               required: 'Please enter the description.',
               minlength: 'Description must be at least 10 characters long.'
           }
       },
       submitHandler: function (form) {
           form.submit();
       }
   });


 //Validation for Changepassword form
   $('#changepasswordForm').validate({
    rules: {
        current_password: {
            required: true,
        },
        new_password: {
            required: true,
            minlength: 8
        },
        confirm_password: {
            required: true,
            equalTo:"#new_password"
        }
    },
    messages: {
        current_password: {
            required: 'Please enter Current Password.'
        },
        new_password: {
            required: 'Please enter New Password.',
            minlength: 'Password must be at least 8 characters long.'
        },
        confirm_password: {
            required: 'Please enter Confirm Password.',
            equalTo: 'Confirm Password do not match with New Password.',
        }
    },
    submitHandler: function (form) {
        form.submit();
    }
});
});