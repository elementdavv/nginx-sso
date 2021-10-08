function init() {
var validator = new Validator('form',[
  {
      name:"email",
      display:"Please enter email|Email is invalid",
      rules: 'required|is_email'
  },{
      name:"password",
      display:"Please enter password|Password 4 chars at min|Password 12 chars at max",
      rules: 'required|min_length(4)|max_length(12)'
  },{
      name:"passwordrepeat",
      display:"Please enter password repeat|Inconsistent passwords",
      rules: 'required|same(password)'
  }
],function(obj,evt){
  var errors_elm = document.querySelector('.error');
  //obj = {
  //  callback:(error, evt, handles)
  //  errors:Array[2]
  //  fields:Object
  //  form:form#example_form
  //  handles:Object
  //  isCallback:true
  //  isEmail:(field)
  //  isFax:(field)
  //  isIp:(field)
  //  isPhone:(field)
  //  isTel:(field)
  //  isUrl:(field)
  //  maxLength:(field, length)
  //  minLength:(field, length)
  //  required:(field)
  //} 
  //console.log(evt);
  //console.log(obj);
  if(obj.errors.length>0){
      var error_str = '';
      for (var i = 0; i < obj.errors.length; i++) {
          error_str += i+1 + ':' + obj.errors[i].message + '<br/>';
      }
      errors_elm.innerHTML = error_str;
  }
})
}
