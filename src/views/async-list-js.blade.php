{{$function}}(){
thisData = Object.assign({}, this.$data)
const requestData = Object.assign({}, getUrlParams(window.location.href));
requestData['currentFunction'] = '{{$class}}'
this.{{$key}}_LOADING = true;
this.{{$key}}_PAGE ++;
{{$requestParams??''}}
let then = this;
axios.get('',{
params:requestData
}).then(ret => {

then.{{$loading}} = false;
then.{{$key}}_LOADING = false;

if(isEmpty(ret.data.data)){
    then.{{$listLoadingFinish}} = true;
    return
}

then.{{$data}} = then.{{$data}}.concat(ret.data.data);

})
},