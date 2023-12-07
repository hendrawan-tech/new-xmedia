$(document).ready(function () {
    tinymce.init({
        selector: "#mymce",
        height: 600,
        menubar: false,
        plugins: [
            "a11ychecker advcode advlist anchor autolink codesample colorpicker contextmenu fullscreen help image imagetools",
            " lists link linkchecker media mediaembed noneditable powerpaste preview",
            " searchreplace table template textcolor tinymcespellchecker visualblocks wordcount",
        ],
        toolbar:
            "insertfile a11ycheck undo redo | bold italic underline | forecolor backcolor | link codesample | alignleft aligncenter alignright alignjustify | bullist numlist | image",
    });
});
