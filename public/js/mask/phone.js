document.addEventListener("DOMContentLoaded",function(){

    let phoneInput = document.querySelectorAll('input[data-tel]');
    
    let getInputNumbersValue = function(input){
        return input.value.replace(/\D/g,"");
    }

    let onPhoneInput = function(e){
        let input = e.target;
        inputValue = getInputNumbersValue(input);
        formatInputValue = "";
        selectionStart = input.selectionStart;

        if(!inputValue){
            return input.value = "";
        }

        if(input.value.length != selectionStart){
            if(e.data && /\D/g.test(e.data)){
                input.data.value = inputValue;
            }
            return;
        }

        if(["3","7","5"].indexOf(inputValue[0]) > -1){

            let firstSymbols = (inputValue[0] == "8") ? "8" : "+3"
            formatInputValue = firstSymbols;

            if (inputValue.length > 1){
                formatInputValue += inputValue.substring(1,3);
            }

            if(inputValue.length >= 4){
                formatInputValue += "(" + inputValue.substring(3,5);
            }
            if(inputValue.length >= 6){
                formatInputValue += ") " + inputValue.substring(5,8);
            }
            if(inputValue.length >= 9){
                formatInputValue += "-" + inputValue.substring(8,10);
            }
            if(inputValue.length >= 11){
                formatInputValue += "-" + inputValue.substring(10,12);
            }

        } else{
            formatInputValue = "+" + inputValue.substring(0,16);
        }

        input.value = formatInputValue;
    }

    // стираем первую цифру
    let onPhoneKeyDown = function(e){
        let input = e.target;
        if(e.keyCode == 8 && getInputNumbersValue(input).length == 1){
            input.value = "";
        }
    }

    for(i=0; i<phoneInput.length; i++){
        let input = phoneInput[i];
        input.addEventListener("input", onPhoneInput);
        input.addEventListener("keydown",onPhoneKeyDown);
    }
})