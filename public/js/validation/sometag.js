document.addEventListener("DOMContentLoaded",function(){
    let tagInput = document.querySelectorAll('[tag-remove-some]');
    let dataHelp = document.querySelector('label[data-help]');

    let replace = function(input){
        return input.value.replace(/(<[^pha][script]{1,7}>)/g,"");
    }

    let onTag = function(e){
        let input = e.target;
        inputValue = replace(input);
        formatInputValue = inputValue;
        if(inputValue.length > inputValue.maxlength){
            formatInputValue += '';
        }
        input.value = formatInputValue;
    }

    for(i=0;i < tagInput.length;i++){
        let input = tagInput[i];
        input.addEventListener("input",onTag);
    }

});