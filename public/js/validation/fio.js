document.addEventListener("DOMContentLoaded",function(){

        let tagInput = document.querySelectorAll('input[fio]');
    
        let replace = function(input){
            return input.value.replace(/[^А-Яа-я]/g,"");
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
    
        for(i=0; i < tagInput.length; i++){
            let input = tagInput[i];
            input.addEventListener("input", onTag);
        }
    });