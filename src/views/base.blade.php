<html lang="en">
<head>
    <title>{{$title??''}}</title>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,viewport-fit=cover">
    {{--    <meta name="viewport">--}}
    {{--    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"--}}
    <meta name="description" content="{{$description??''}}"/>
    <meta name="keywords" content="{{$keywords??''}}"/>


</head>


<style>
    .loading {
        --r1: 154%;
        --r2: 68.5%;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: radial-gradient(var(--r1) var(--r2) at top, #0000 79.5%, #269af2 80%) center left,
        radial-gradient(var(--r1) var(--r2) at bottom, #269af2 79.5%, #0000 80%) center center,
        radial-gradient(var(--r1) var(--r2) at top, #0000 79.5%, #269af2 80%) center right,
        #ccc;
        background-size: 50.5% 220%;
        background-position: -100% 0%, 0% 0%, 100% 0%;
        background-repeat: no-repeat;
        animation: p9 2s infinite linear;
    }

    @keyframes p9 {
        33% {
            background-position: 0% 33%, 100% 33%, 200% 33%
        }

        66% {
            background-position: -100% 66%, 0% 66%, 100% 66%
        }

        100% {
            background-position: 0% 100%, 100% 100%, 200% 100%
        }
    }

    #loading-box {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    body {
        background-color: #f5f5f5;
    }

    .title {
        padding: 32px 16px 16px;
        color: rgba(69, 90, 100, 0.6);
        font-weight: normal;
        font-size: 14px;
    }

    .van-pull-refresh {
        overflow-y: auto !important;
    }

</style>

<body>

<div id="loading-box">
    <div>
        <div id="loading" class="loading"></div>
        <div style="color: #dcdcdc ;display: flex;justify-content: center;margin-top: 10px">加载中</div>
    </div>
</div>

<div id="app" >
{{--    style="visibility: hidden;"--}}

    <van-pull-refresh v-model="isReflash" @refresh="onRefresh"
    >
        <div>
            {!! $content !!}
        </div>
    </van-pull-refresh>

</div>
<link href="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-5-y/vant/2.12.44/index.min.css" type="text/css"
      rel="stylesheet"/>
<script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-12-M/vue/2.6.14/vue.min.js"
        type="application/javascript"></script>
<script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-5-y/vant/2.12.44/vant.min.js"
        type="application/javascript"></script>
<script src="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-5-y/axios/0.26.0/axios.min.js"
        type="application/javascript"></script>

<script>

    window.onload = function () {

        document.getElementById("loading-box").style.display = "none";
        document.getElementById("app").style.visibility = "visible";

    }
</script>

<script>
    function isEmpty(variable) {
        if (variable === null || variable === undefined) {
            return true;
        }

        if (Array.isArray(variable) && variable.length === 0) {
            return true;
        }

        return false;
    }


    function getUrlParams(url) {

        let obj = {};

        if(url.indexOf('?') == -1 ){
            return obj;
        }

        // 通过 ? 分割获取后面的参数字符串
        let urlStr = url.split('?')[1]
        // 创建空对象存储参数

        // 再通过 & 将每一个参数单独分割出来
        let paramsArr = urlStr.split('&')
        for(let i = 0,len = paramsArr.length;i < len;i++){
            // 再通过 = 将每一个参数分割为 key:value 的形式
            let arr = paramsArr[i].split('=')
            obj[arr[0]] = arr[1];
        }
        return obj
    }

</script>


<script>
    new Vue({
        el: '#app',
        data: {
            date: '',
            username: '',
            isReflash: false,
            isLoading: false,
            active: 2,
            {!! $vueData !!}
        },
        created() {
            {!! $init !!}
        },
        methods: {
            onSelect(item) {
                // 默认情况下点击选项时不会自动收起
                // 可以通过 close-on-click-action 属性开启自动收起
                this.show = false;
                this.$dialog.alert({
                    title: '标题',
                    message: '弹窗内容',
                }).then(() => {
                    // on close
                });
            },
            formatDate(date) {
                return `${date.getMonth() + 1}/${date.getDate()}`;
            },
            onConfirm(date) {
                this.show = false;
                this.date = this.formatDate(date);
            },
            getMethodName() {
                const error = new Error();
                const stackTrace = error.stack.split("\n")[2]; // 获取调用栈的第三行
                const methodName = stackTrace.match(/at\s+(.*)\s+\(/)[1]; // 从调用栈中提取方法名
                return methodName;
            },
            onRefresh() {
                location.reload();
            },


            {!! $method??'' !!}
        },
    });
    Vue.use(vant.Lazyload);
</script>



</body>
</html>
