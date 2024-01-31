@extends('adminlte::layouts.app')

@section('title', 'Hỗ trợ khách hàng')

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">
    <style>
        .content-header {
            display: none;
        }
        /*
        *   Bootstrap 3.4.1 -> 4.6.1
        */
        .p-0 {
            padding: 0;
        }
        .m-0 {
            margin: 0;
        }
        .mb-0 {
            margin-bottom: 0;
        }
        .w-100 {
            width: 100%;
        }
        .h-100 {
            height: 100%;
        }
        .d-none {
            display: none;
        }
        .d-flex {
            display: flex;
        }
        .flex-column {
            flex-direction: column;
        }
        .align-items-center {
            align-items: center;
        }
        .justify-content-center {
            justify-content: center;
        }
        .justify-content-between {
            justify-content: space-between;
        }
        .position-absolute {
            position: absolute;
        }
        .fw-bold {
            font-weight: bold;
        }

        /*
        *   Chat CSS
        */
        .content-container *:not(i, a, span.message-reply) {
            font-family: "Nunito", sans-serif;
            font-size: 12px;
            color: black;
        }
        .content-container {
            width: 100% !important;
            height: calc(100vh - 84px);
            overflow-y: auto;
            /* min-height: 600px !important; */
            background-color: black;
            border: 1px solid rgb(65, 31, 31);
        }

        /*
        *
        *   Chat rooms
        *
        */

        #message-nav {
            height: 100%;
            border-right: 1px solid lightgray;
            background-color: white;
        }

        #message-nav > span {
            width: 100%;
            height: 24px;
            vertical-align: middle;
            background-color: #555;
            color: white;
            display: flex;
            align-items: center;
            text-indent: 10px;
        }

        #message-nav .thumbnail-user img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }

        #message-nav > div {
            max-height: 50%;
            overflow-y: auto;
        }

        #message-nav > div > div.show-all-rooms, #message-nav > div > div.show-less-rooms {
            height: 25px;
        }

        .chat-list {
            height: 50px;
            border-bottom: 1px solid lightgray;
            cursor: pointer;
        }

        .chat-list.active {
            background-color: #f2f2f2;
        }

        /*
        *
        *   Chat messages
        *
        */
        #message-detail .chat-overlay {
            top: 0px;
            left: 0px;
            background-color: #f2f2f2;
        }

        .chat-overlay > p {
            font-size: large;
        }

        .chat-container {
            /* width: 320px; */
            /* height: 360px; */
            background-color: #e8e8e8;
            display: flex;
            flex-direction: column;
            /* border: 1px solid lightgray; */
        }

        #chat-header {
            top: 0px;
            height: 32px;
            background-color: gray;
        }

        #chat-history-container {
            position: relative;
            width: 100%;
            height: calc(100% - 32px - 32px);
            border-top: 1px solid lightgray;
            border-bottom: 1px solid lightgray;
        }

        #chat-history {
            position: absolute;
            bottom: 0px;
            left: 0px;
            width: 100%;
            max-height: 100%;
            padding: 0px 10px;
            height: fit-content;
            overflow-y: auto;
        }

        #chat-history .chat-detail {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        #chat-history .chat-system {
            flex-direction: row-reverse;
        }

        #chat-history .chat-user {
            flex-direction: row;
        }

        #chat-history .chat-avatar {
            top: 0px !important;
        }

        #chat-history .chat-avatar img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }

        #chat-history .chat-message-list {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .chat-message-list div.reply-note {
            display: flex;
            flex-direction: column;
            margin-top: 3px;
        }
        .chat-user .chat-message-list div.reply-note {
            margin-left: 5px;
        }
        .chat-system .chat-message-list div.reply-note {
            margin-right: 5px;
        }
        .chat-message-list div.reply-note > span {
            font-size: x-small;
            margin-bottom: -2px;
            width: fit-content;
        }
        .chat-message-list div.reply-note > span:last-child {
            /* background-color: #f7e3b4; */
            background-color: #f2f2f2;
            opacity: 0.6;
            border-radius: 5px;
            padding: 1px 3px;
        }
        .chat-system .chat-message-list div.reply-note {
            align-items: flex-end;
        }
        .chat-message-list div.reply-note img {
            height: 50px;
            width: fit-content;
            max-width: 50px;
            border-radius: 3px;
            opacity: 0.6;
        }

        .chat-system .chat-message-list > div.w-100 {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        #chat-history .chat-message:has(> div:first-child) {
            position: relative;
            padding: 4px 8px;
            margin: 0px 5px 2px 5px;
            background-color: #f2f2f2;
            /* background-color: #f7e3b4; */
            border-radius: 8px;
            min-height: 28px;
            max-width: 64%;
            width: fit-content;
            display: flex;
            align-items: center;
        }

        #chat-history .chat-message div {
            overflow-wrap: anywhere;
        }

        #chat-history .chat-message div > p:last-child {
            margin-bottom: 0px;
        }

        #chat-history .chat-message:has(> span:first-child) {
            position: relative;
            padding: 4px 8px;
            margin: 0px 5px 2px 5px;
            background-color: #f2f2f2;
            border-radius: 8px;
            min-height: 28px;
            max-width: 64%;
            width: fit-content;
            display: flex;
            align-items: center;
        }

        #chat-history .chat-message span {
            overflow-wrap: anywhere;
        }

        #chat-history .chat-message:has(> img:first-child) {
            position: relative;
            margin: 0px 5px 2px 5px;
            min-height: 28px;
            max-width: 64%;
            width: fit-content;
            display: flex;
            align-items: center;
        }

        #chat-history .chat-message img {
            width: 100%;
            border-radius: 8px;
            max-height: 160px;
            min-height: 28px;
            object-fit: contain;
        }

        #chat-input form {
            position: relative;
            min-height: 32px;
            background-color: white;
            display: flex;
            align-items: center;
            padding: 2px 0px;
            margin: 0px;
        }

        #chat-input textarea {
            width: 100%;
            min-height: fit-content;
            max-height: 50px;
            padding: 0px 42px 0px 16px;
            outline: none !important;
            border: none !important;
            resize: none;
            overflow-y: auto;
        }

        #chat-input .chat-widget-container {
            display: flex;
            flex-direction: row;
            margin: 0px 10px;
        }

        .chat-widget-container button {
            position: relative;
            border: none;
            background-color: transparent;
            margin: 0px 5px;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-widget-container button input {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
        }

        input[type=file],
        input[type=file]::-webkit-file-upload-button {
            cursor: pointer; 
        }

        .chat-widget-container button:hover {
            color: green;
            cursor: pointer;
        }
        
        /*
        *   Reply section CSS
        */
        .message-reply {
            display: none;
            color: lightgray;
            cursor: pointer;
            width: fit-content;
        }
        .chat-message-list > div.w-100 .message-reply {
            right: -20px;
        }
        .chat-system .chat-message-list > div.w-100 .message-reply {
            left: -20px;
        }
        .chat-message-list > div.w-100:hover .message-reply {
            display: block;
        }

        #chat-reply {
            position: absolute;
            bottom: 0;
            height: 56px;
            width: 100%;
            background-color: #f7e3b4;
            padding: 10px 15px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            display: none;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        #chat-reply.d-flex {
            display: flex;
        }
        #chat-reply #chat-reply-container {
            position: relative;
            height: 36px;
            display: flex;
            flex-direction: row;
            align-items: center;
            border-left: 1px solid #f9bd43;
            padding: 0px 10px;
        }
        #chat-reply-container #reply-image {
            height: 100%;
            width: auto;
            max-width: 80px;
            object-fit: contain;
            margin-right: 10px;
            display: none;
        }
        #chat-reply-container #reply-image.d-show {
            display: block;
        }
        #chat-reply-container #reply-detail {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        #chat-reply #reply-cancel {
            border: none;
            background: transparent;
            height: fit-content;
            margin-right: 12px;
        }
    </style>
@stop

@section('content')
    <div class="content-container row w-100 m-0 p-0">
        <div class="col-xs-4 m-0 p-0 d-flex flex-column" id="message-nav">
            <span id="current-rooms-span">Current</span>
            <div id="current-container">
                <ul class="w-100 list-unstyled mb-0" id="current-rooms">
                </ul>
                <div class="w-100 d-none justify-content-center align-items-center show-all-rooms" id="show-all-current" role="button">
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="w-100 d-none justify-content-center align-items-center show-less-rooms" id="show-less-current" role="button">
                    <i class="fas fa-chevron-up"></i>
                </div>
            </div>
            <span id="waiting-rooms-span">Waiting</span>
            <div id="waiting-container">
                <ul class="w-100 list-unstyled mb-0" id="waiting-rooms">
                </ul>
                <div class="w-100 d-none justify-content-center align-items-center show-all-rooms" id="show-all-waiting" role="button">
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="w-100 d-none justify-content-center align-items-center show-less-rooms" id="show-less-waiting" role="button">
                    <i class="fas fa-chevron-up"></i>
                </div>
            </div>
        </div>
        <div class="col col-xs-8 m-0 p-0 h-100" id="message-detail">
            <div class="chat-container w-100 h-100">
                <div id="chat-header">
                    <div class="header-title"></div>
                    <div class="header-function"></div>
                </div>
                <div id="chat-history-container">
                    <div id="chat-history"></div>
                    <div id="chat-reply">
                        <div id="chat-reply-container">
                            <img src="" id="reply-image" class="">
                            <div id="reply-detail">
                                <span id="reply-name" class="fw-bold"></span>
                                <span id="reply-content"></span>
                            </div>
                        </div>
                        <button id="reply-cancel">
                            <i class="fas fa-times m-0"></i>
                        </button>
                    </div>
                </div>
                <div id="chat-input">
                    <form>
                        <textarea id="message" placeholder="Aa" rows="1"></textarea>
                        <div class="chat-widget-container">
                            <button type="button">
                                <i class="fas fa-image"></i>
                                <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
                            </button>
                            <!-- <button type="button">
                                <i class="fa-solid fa-paperclip"></i>
                                <input type="file" name="file" id="file">
                            </button> -->
                        </div>
                    </form>
                </div>
            </div>
            <div class="chat-overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center">
                <p>Please select a chat room</p>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        var system_data = {
            id: "{{ $user_data->id }}",
            name: "{{ $user_data->name }}",
            email: "{{ $user_data->email }}",
            phone: "{{ $user_data->phone }}",
            avatar_url: "{{ $user_data->avatar_url }}",
        }
        system_data.avatar_url = "https://gozic.vn/uploads/stores/184/2023/11/icon-gozic.webp";
    </script>
    <script>
        function formatTimestampDisplay(time) {
            let time_diff_s = Math.floor(new Date().getTime()/1000 - time);
            // console.log(time_diff_s)
            let represent = "";
            let time_represents = [
                {
                    "time": 60*30,
                    "represent": "30m ago"
                },
                {
                    "time": 60*15,
                    "represent": "15m ago"
                },
                {
                    "time": 60*10,
                    "represent": "10m ago"
                },
                {
                    "time": 60*5,
                    "represent": "5m ago"
                },
                {
                    "time": 60,
                    "represent": "1m ago"
                },
                {
                    "time": 30,
                    "represent": "30s ago"
                },
                {
                    "time": 15,
                    "represent": "15s ago"
                },
                {
                    "time": 0,
                    "represent": "just now"
                }
            ];
            if (60*60*36 <= time_diff_s) {
                let date = new Date(time*1000);
                return date.getFullYear() + "/" + (date.getMonth() < 9 ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1)) + "/" + (date.getDate() < 10 ? "0" + date.getDate() : date.getDate());
            }
            if (60*60*24 <= time_diff_s) return "yesterday";
            if (60*60 <= time_diff_s) return Math.floor(time_diff_s / (60*60)) + "h ago";
            represent = time_represents[time_represents.findIndex(time_represent => time_diff_s >= time_represent.time)].represent;
            return represent;
        }

        function autoUpdateTimeRepresent() {
            setInterval(() => {
                // console.log("hi");
                $(".message-timestamp").each((index, element) => {
                    let time_display = formatTimestampDisplay($(element).data("timestamp"));
                    // console.log(time_display);
                    $(element).html($(element).data("unread") ? ("<b>" + time_display + "</b>") : time_display);
                })
            }, 15000);
        }

        function shortenStringDisplay(text, length) {
            text = '' + text;
            if (text.length <= length) return text;
            return text.substr(0, length) + "...";
        }

        function reverseObjectKeys(originalObject) {
            const originalKeys = Object.keys(originalObject);
            const reversedKeys = originalKeys.reverse();
        
            const reversedObject = {};
        
            for (const key of reversedKeys) {
            reversedObject[key] = originalObject[key];
            }
        
            return reversedObject;
        }

        // Upload image API
        async function uploadFile(file, callback) {
            // if (file != null) {
            //     if (!file.name.match(/.(jpg|jpeg|png|gif|bmp|webp)$/i))
            //         return alert('HĂ¬nh áº£nh báº¡n táº£i lĂªn khĂ´ng Ä‘Ăºng Ä‘á»‹nh dáº¡ng file, vui lĂ²ng kiá»ƒm tra láº¡i (jpg, jpeg, png, bmp, gif)');
            // }
            // if (file.size > (30 * 1024 * 1024)) { 
            //     return alert('Dung lÆ°á»£ng file áº£nh quĂ¡ lá»›n -> YĂªu cáº§u file dung lÆ°á»£ng <= 30M') 
            // }
            // var url = '//gozic.vn/api/upload'
            var url = '//appbanhang.gozic.vn/api/upload'
            var xhr = new XMLHttpRequest(); 
            var fd = new FormData(); 
            xhr.open('POST', url, true); 
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); 
            xhr.onreadystatechange = function (e) {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var obj = JSON.parse(xhr.responseText)
                    console.log(obj);
                    if (obj.status == 0) {
                        alert(obj.msg)
                        return
                    }
                    callback(obj.url)
                }
            }; 
            fd.append('tags', 'browser_upload'); 
            if (file != null) { 
                fd.append('file', file); 
            }
            fd.append('isWaterMask', false); 
            fd.append('watermask', ""); 
            fd.append('idCat', 0); 
            fd.append('color', ""); 
            fd.append('enabled', 1); 
            xhr.send(fd);
        }
    </script>
    <script>
        /*!
        * Image Compressor v1.1.4
        * https://xkeshi.github.io/image-compressor
        *
        * Copyright 2017-present Chen Fengyuan
        * Released under the MIT license
        *
        * Date: 2018-06-20T07:28:41.051Z
        */
        !function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):e.ImageCompressor=t()}(this,function(){"use strict";var e,k=(function(e){var t,a,f,s,h,d,i;t=window,a=t.HTMLCanvasElement&&t.HTMLCanvasElement.prototype,f=t.Blob&&function(){try{return Boolean(new Blob)}catch(e){return!1}}(),s=f&&t.Uint8Array&&function(){try{return 100===new Blob([new Uint8Array(100)]).size}catch(e){return!1}}(),h=t.BlobBuilder||t.WebKitBlobBuilder||t.MozBlobBuilder||t.MSBlobBuilder,d=/^data:((.*?)(;charset=.*?)?)(;base64)?,/,i=(f||h)&&t.atob&&t.ArrayBuffer&&t.Uint8Array&&function(e){var t,r,n,a,i,o,l,u,c;if(!(t=e.match(d)))throw new Error("invalid data URI");for(r=t[2]?t[1]:"text/plain"+(t[3]||";charset=US-ASCII"),n=!!t[4],a=e.slice(t[0].length),i=n?atob(a):decodeURIComponent(a),o=new ArrayBuffer(i.length),l=new Uint8Array(o),u=0;u<i.length;u+=1)l[u]=i.charCodeAt(u);return f?new Blob([s?l:o],{type:r}):((c=new h).append(o),c.getBlob(r))},t.HTMLCanvasElement&&!a.toBlob&&(a.mozGetAsFile?a.toBlob=function(e,t,r){var n=this;setTimeout(function(){r&&a.toDataURL&&i?e(i(n.toDataURL(t,r))):e(n.mozGetAsFile("blob",t))})}:a.toDataURL&&i&&(a.toBlob=function(e,t,r){var n=this;setTimeout(function(){e(i(n.toDataURL(t,r)))})})),e.exports?e.exports=i:t.dataURLtoBlob=i}(e={exports:{}},e.exports),e.exports),o=Object.prototype.toString,t={checkOrientation:!0,maxWidth:1/0,maxHeight:1/0,minWidth:0,minHeight:0,width:void 0,height:void 0,quality:.8,mimeType:"auto",convertSize:5e6,beforeDraw:null,drew:null,success:null,error:null},r=/^image\/.+$/;function A(e){return r.test(e)}var m=String.fromCharCode;var l=window.btoa;function u(e){var t=new DataView(e),r=void 0,n=void 0,a=void 0,i=void 0;if(255===t.getUint8(0)&&216===t.getUint8(1))for(var o=t.byteLength,l=2;l<o;){if(255===t.getUint8(l)&&225===t.getUint8(l+1)){a=l;break}l+=1}if(a){var u=a+10;if("Exif"===function(e,t,r){var n="",a=void 0;for(r+=t,a=t;a<r;a+=1)n+=m(e.getUint8(a));return n}(t,a+4,4)){var c=t.getUint16(u);if(((n=18761===c)||19789===c)&&42===t.getUint16(u+2,n)){var f=t.getUint32(u+4,n);8<=f&&(i=u+f)}}}if(i){var s=t.getUint16(i,n),h=void 0,d=void 0;for(d=0;d<s;d+=1)if(h=i+12*d+2,274===t.getUint16(h,n)){h+=8,r=t.getUint16(h,n),t.setUint16(h,1,n);break}}return r}var n=/\.\d*(?:0|9){12}\d*$/i;function R(e){var t=1<arguments.length&&void 0!==arguments[1]?arguments[1]:1e11;return n.test(e)?Math.round(e*t)/t:e}var a=function(){function n(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(e,t,r){return t&&n(e.prototype,t),r&&n(e,r),e}}(),c=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r)Object.prototype.hasOwnProperty.call(r,n)&&(e[n]=r[n])}return e},i=window,f=i.ArrayBuffer,s=i.FileReader,h=window.URL||window.webkitURL,d=/\.\w+$/;return function(){function r(e,t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,r),this.result=null,e&&this.compress(e,t)}return a(r,[{key:"compress",value:function(B,M){var x=this,T=new Image;return M=c({},t,M),f||(M.checkOrientation=!1),new Promise(function(r,e){if((t=B)instanceof Blob||"[object Blob]"===o.call(t)){var t,n=B.type;if(A(n))if(h||s){if(h&&!M.checkOrientation)r({url:h.createObjectURL(B)});else if(s){var a=new s,i=M.checkOrientation&&"image/jpeg"===n;a.onload=function(e){var t=e.target.result;r(i?c({url:function(e,t){var r=new Uint8Array(e),n="";if("function"==typeof r.forEach)r.forEach(function(e){n+=m(e)});else for(var a=r.length,i=0;i<a;i+=1)n+=m(r[i]);return"data:"+t+";base64,"+l(n)}(t,n)},function(e){var t=0,r=1,n=1;switch(e){case 2:r=-1;break;case 3:t=-180;break;case 4:n=-1;break;case 5:t=90,n=-1;break;case 6:t=90;break;case 7:t=90,r=-1;break;case 8:t=-90}return{rotate:t,scaleX:r,scaleY:n}}(u(t))):{url:t})},a.onabort=function(){e(new Error("Aborted to load the image with FileReader."))},a.onerror=function(){e(new Error("Failed to load the image with FileReader."))},i?a.readAsArrayBuffer(B):a.readAsDataURL(B)}}else e(new Error("The current browser does not support image compression."));else e(new Error("The first argument must be an image File or Blob object."))}else e(new Error("The first argument must be a File or Blob object."))}).then(function(r){return new Promise(function(e,t){T.onload=function(){return e(c({},r,{naturalWidth:T.naturalWidth,naturalHeight:T.naturalHeight}))},T.onabort=function(){t(new Error("Aborted to load the image."))},T.onerror=function(){t(new Error("Failed to load the image."))},T.alt=B.name,T.src=r.url})}).then(function(e){var b=e.naturalWidth,w=e.naturalHeight,t=e.rotate,p=void 0===t?0:t,r=e.scaleX,y=void 0===r?1:r,n=e.scaleY,U=void 0===n?1:n;return new Promise(function(t){var e=document.createElement("canvas"),r=e.getContext("2d"),n=b/w,a=Math.max(M.maxWidth,0)||1/0,i=Math.max(M.maxHeight,0)||1/0,o=Math.max(M.minWidth,0)||0,l=Math.max(M.minHeight,0)||0,u=b,c=w;if(a<1/0&&i<1/0?a<i*n?i=a/n:a=i*n:a<1/0?i=a/n:i<1/0&&(a=i*n),0<o&&0<l?o<l*n?l=o/n:o=l*n:0<o?l=o/n:0<l&&(o=l*n),0<M.width)c=(u=M.width)/n;else if(0<M.height){u=(c=M.height)*n}var f=-(u=Math.min(Math.max(u,o),a))/2,s=-(c=Math.min(Math.max(c,l),i))/2,h=u,d=c;if(Math.abs(p)%180==90){var m={width:c,height:u};u=m.width,c=m.height}e.width=R(u),e.height=R(c),A(M.mimeType)||(M.mimeType=B.type);var g="transparent";B.size>M.convertSize&&"image/png"===M.mimeType&&(g="#fff",M.mimeType="image/jpeg"),r.fillStyle=g,r.fillRect(0,0,u,c),r.save(),r.translate(u/2,c/2),r.rotate(p*Math.PI/180),r.scale(y,U),M.beforeDraw&&M.beforeDraw.call(x,r,e),r.drawImage(T,Math.floor(R(f)),Math.floor(R(s)),Math.floor(R(h)),Math.floor(R(d))),M.drew&&M.drew.call(x,r,e),r.restore();var v=function(e){t({naturalWidth:b,naturalHeight:w,result:e})};e.toBlob?e.toBlob(v,M.mimeType,M.quality):v(k(e.toDataURL(M.mimeType,M.quality)))})}).then(function(e){var t=e.naturalWidth,r=e.naturalHeight,n=e.result;if(h&&!M.checkOrientation&&h.revokeObjectURL(T.src),n)if(n.size>B.size&&M.mimeType===B.type&&!(M.width>t||M.height>r||M.minWidth>t||M.minHeight>r))n=B;else{var a=new Date;n.lastModified=a.getTime(),n.lastModifiedDate=a,n.name=B.name,n.name&&n.type!==B.type&&(n.name=n.name.replace(d,function(e){var t=!(1<arguments.length&&void 0!==arguments[1])||arguments[1],r=A(e)?e.substr(6):"";return"jpeg"===r&&(r="jpg"),r&&t&&(r="."+r),r}(n.type)))}else n=B;return x.result=n,M.success&&M.success.call(x,n),Promise.resolve(n)}).catch(function(e){if(!M.error)throw e;M.error.call(x,e)})}}]),r}()});
    </script>
    <script type="module">
        // Import modules
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-analytics.js";
        import { getAuth, connectAuthEmulator } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";
        // import { getDatabase, connectDatabaseEmulator, ref, child, push, get, set, update, serverTimestamp, onValue, off, query, orderByChild, equalTo, limitToLast } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";
        import { getFirestore, connectFirestoreEmulator, collection, orderBy, getDocs, doc, getDoc, addDoc, setDoc, updateDoc, serverTimestamp, onSnapshot, query, where } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";

        // Initialize Firebase
        // const firebaseConfig = {
        //     apiKey: "AIzaSyB7OEUgaGaipy8nWbAYXacrLNNNVEYZm_4",
        //     authDomain: "chat-bot-ec322.firebaseapp.com",
        //     databaseURL: "https://chat-bot-ec322-default-rtdb.asia-southeast1.firebasedatabase.app",
        //     projectId: "chat-bot-ec322",
        //     storageBucket: "chat-bot-ec322.appspot.com",
        //     messagingSenderId: "765269828752",
        //     appId: "1:765269828752:web:c173315fcc8095e82b6415",
        //     measurementId: "G-52EMCT879B"
        // };
        const firebaseConfig = {
            apiKey: "AIzaSyDw2S01aViwowyyJ-A0m7pVTX8OIZF2VJU",
            authDomain: "ziczacapp.firebaseapp.com",
            databaseURL: "https://ziczacapp-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "ziczacapp",
            storageBucket: "ziczacapp.appspot.com",
            messagingSenderId: "1054197522212",
            appId: "1:1054197522212:web:02a6765b198580e53f9db1",
            measurementId: "G-8XQG0CX88E"
        };
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
        // var db = getDatabase(app);
        var auth = getAuth(app);
        var fs = getFirestore(app);
        // Use emulators
        // connectDatabaseEmulator(db, 'localhost', 9000);
        // connectAuthEmulator(auth, "http://127.0.0.1:9099");
        // connectFirestoreEmulator(fs, '127.0.0.1', 8082);
        // const system_data = {
        //     id: "S10001",
        //     name: "Nguyen Admin",
        //     email: "admin@gmail.com",
        //     gender: 1,
        //     avatarUrl: "/assets/image/system.jpg",
        // }
        let customer_data = {};
        let avatar_list = {
            "admin": "/assets/image/icon-gozic.png",
            "system": "/assets/image/icon-gozic.png"
        }
        $(document).ready(function() {
            $("p.firebase-emulator-warning").remove();
        })

        /* 
        *
        * Document elements & functions
        * 
        */
        // Elements for manage rooms
        var message_nav_container_current = document.querySelector("#message-nav ul#current-rooms");
        var message_nav_container_waiting = document.querySelector("#message-nav ul#waiting-rooms");

        // Elements for manage chat
        var chat_history = document.querySelector("#chat-history");
        var last_message_list = document.querySelector("#chat-history .chat-detail:last-child");
        var last_message = document.querySelector("#chat-history .chat-detail:last-child .chat-message:last-child");
        var message_input = document.querySelector("#chat-input textarea#message");
        var default_input_height = message_input.scrollHeight;

        // Declare markdown converter object
        var md = window.markdownit();
        // Remember the old renderer if overridden, or proxy to the default renderer.
        var defaultRender = md.renderer.rules.link_open || function (tokens, idx, options, env, self) {
            return self.renderToken(tokens, idx, options);
        };
        md.renderer.rules.link_open = function (tokens, idx, options, env, self) {
            // Add a new `target` attribute, or replace the value of the existing one.
            tokens[idx].attrSet('target', '_blank');

            // Pass the token to the default renderer.
            return defaultRender(tokens, idx, options, env, self);
        };

        // Declair common variables
        var current_room_list = [];
        var waiting_room_list = [];
        var is_show_all_current = false;
        var is_show_all_waiting = false;
        var room_id = null; // current selected room
        var max_room = 3;

        var reply = {
            id: "",
            check: 1,
            reply: "",
            name: "",
            images: []
        }

        // scrollToLastMessage();

        function sendMessage(event) {
            event.preventDefault();
            if (message_input.value.trim() == '') {
                return;
            }
            addMessage(message_input.value.trim());
            message_input.value = "";
            message_input.style.height = default_input_height;
        }

        // document.querySelector("#submit-btn").addEventListener("click", (event) => sendMessage(event, this));

        function renderMessage(message, is_reply=false, reply, avatar_url = avatar_list) {
            console.log(is_reply, reply);
            let message_content = "";
            switch (message.type) {
                case "image":
                    message_content = "<img src='" + message.content + "'>";
                    break;
                case "markdown":
                    message_content = "<div>" + md.render(message.content) + "</div>";
                    break;
                default:
                    message_content = "<span>" + message.content + "</span>";
                    break;
            }

            let reply_content = "";
            if (is_reply) {
                if (reply.type == "text") reply_content = "<div class='reply-note'><span>" + shortenStringDisplay(reply.message, 30) + "</span></div>";
                else reply_content = "<div class='reply-note'><img src='" + reply.images[0] +"'></div>";
            }
            // console.log(message_content);
            if (last_message_list && last_message_list.classList.contains("chat-" + message.role)) {
                last_message_list.querySelector(".chat-message-list").innerHTML +=
                    "<div class='w-100'>" +
                        reply_content +
                        "<div class='chat-message " + message.role + "-message'>" +
                            message_content +
                            "<span class='position-absolute message-reply' id='" + message.id + "' data-message-type='" + message.type + "'>" +
                                "<i class='fas fa-fw fa-reply'></i>" +
                            "</span>" +
                        "</div>" +
                    "</div>";
            } else {
                chat_history.innerHTML +=
                    "<div class='chat-detail chat-" + message.role + "'>" +
                        "<div class='chat-avatar " + message.role + "-avatar'>" +
                            "<img src='" + avatar_url[message.role] + "'>" +
                        "</div>" +
                        "<div class='chat-message-list'>" +
                            "<div class='w-100'>" +
                                reply_content +
                                "<div class='chat-message " + message.role + "-message'>" +
                                    message_content +
                                    "<span class='position-absolute message-reply' id='" + message.id + "' data-message-type='" + message.type + "'>" +
                                        "<i class='fas fa-fw fa-reply'></i>" +
                                    "</span>" +
                                "</div>" +
                            "</div>" +
                        "</div>";
                    "</div>";
            }
            last_message_list = document.querySelector("#chat-history .chat-detail:last-child");
            last_message = document.querySelector("#chat-history .chat-detail:last-child .chat-message:last-child");
        }

        // Re-render old messages
        function renderOldMessage(messages, participants=[]) {
            // console.log(messages, participants);
            messages.forEach((message) => {
                console.log(message.data())
                let message_data = {
                    id: message.id,
                    type: "text",
                    content: message.data().chat,
                    role: ""
                };
                if (message.data().images.length > 0) {
                    message_data.type = "image";
                    message_data.content = message.data().images[0];
                }

                let is_reply = message.data().check != 1 ?? false;
                let reply_data = {
                    type: "text",
                    message: message.data().reply,
                    images: []
                }
                if ([3, 4, 5, 6].includes(message.data().check)) {
                    console.log()
                    reply_data.type = "image";
                    reply_data.message = "";
                    reply_data.images = message.data().replyimages;
                }
                switch (message.data().senderId) {
                    case 0:
                        message_data.role = "system";
                        renderMessage(message_data, is_reply, reply_data);
                        break;
                    case participants[1]:
                        message_data.role = "system";
                        renderMessage(message_data, is_reply, reply_data);
                        break;
                    case participants[0]:
                        message_data.role = "user";
                        renderMessage(message_data, is_reply, reply_data);
                        break;
                }
            });
            let loadedImages = 0;
            $("#chat-history img").on('load', function () {
                loadedImages++;
                // Check if all images are loaded because of using link src
                if (loadedImages === $("#chat-history img").length) {
                    scrollToLastMessage();
                }
            });
        }

        // Re-render old rooms
        async function renderOldRooms(room_list=[], message_nav_container) {
            let message_container_element = "";
            room_list.forEach((room) => {
                message_container_element += 
                    "<li class='row d-flex align-items-center w-100 chat-list m-0 p-0' id='" + room.id + "'>" +
                        "<div class='col-xs-2 thumbnail-user d-flex align-items-center justify-content-center'>" +
                            "<img src='" + room.customer.avatar_url + "'>" +
                        "</div>" +
                        "<div class='col-xs-10 d-flex justify-content-center flex-column'>" +
                            "<div class='message-info d-flex justify-content-between'>" +
                                "<span class='fw-bold user-name'>" + shortenStringDisplay(room.customer.name, 12) + "</span>" +
                                "<span class='message-timestamp' data-timestamp='" + room.timestamp.seconds + "' data-unread='" + room.unread + "'>" + ((room.unread) ? ("<b>" + room.time_display + "</b>") : room.time_display) + "</span>" +
                            "</div>" +
                            "<span class='message-content'>" + ((room.unread) ? ("<b>" + room.message_content + "</b>") : room.message_content) + "</span>" +
                        "</div>" +
                    "</li>";
                }
            );
            message_nav_container.innerHTML = message_container_element;
        }
        autoUpdateTimeRepresent();

        function scrollToLastMessage() {
            if (last_message) $("#chat-history .chat-detail:last-child .chat-message-list .w-100:last-child .chat-message:last-child")[0].scrollIntoView({ behavior: "auto" });
        }

        message_input.oninput = function() {
            message_input.style.height = default_input_height + "px";
            message_input.style.height = (message_input.scrollHeight) + "px";
        };

        message_input.onkeypress = function(event) {
            if(event.which === 13 && !event.shiftKey) {
                event.preventDefault();
                sendMessage(event);
            }
        };

        // Catch choosing room event
        document.getElementById('message-nav').addEventListener('click', function(event) {
            let targetElement = event.target;
            while (targetElement && targetElement !== document) {
                if (targetElement.classList.contains("chat-list")) {
                    room_id = targetElement.id;
                    // console.log(current_room_list);
                    if (current_room_list.filter(current_room => current_room.id == room_id).length == 1) {
                        console.log("Pass")
                        $(".chat-overlay").remove();
                        for (var item of document.querySelectorAll(".chat-list")) {
                            item.classList.remove('active');
                        }
                        targetElement.classList.add("active");
                        syncMessage(room_id);
                    } else {
                        let choice = confirm("Are you sure to enter this room?");
                        if (choice) {
                            $(".chat-overlay").remove();
                            for (var item of document.querySelectorAll(".chat-list")) {
                                item.classList.remove('active');
                            }
                            targetElement.classList.add("active");
                            syncMessage(room_id);
                        }
                    }
                    break;
                }
                targetElement = targetElement.parentNode;
            }
        });

        $(document).on("click", "div#show-all-current", function() {
            showAllCurrent();
        });
        $(document).on("click", "div#show-less-current", function() {
            showLessCurrent();
        });

        $(document).on("click", "div#show-all-waiting", function() {
            showAllWaiting();
        });
        $(document).on("click", "div#show-less-waiting", function() {
            showLessWaiting();
        });

        function showAllCurrent() {
            // console.log("show all current");
            $("#show-all-current").removeClass('d-flex').addClass('d-none');
            if (is_show_all_waiting) {
                showLessWaiting();
            }

            let section_status_span = $("#current-rooms-span").height() * 2;
            let section_chat_room_height = $("div.content-container").height();
            let section_current_height = $("#current-container").height();
            let section_waiting_height = $("#waiting-container").height();
            if (current_room_list.length > max_room) {
                $("#current-container").css({ "height": (section_chat_room_height - section_waiting_height - section_status_span) + "px", "overflow-y": "auto", "max-height": "none" });
                $("#show-less-current").removeClass('d-none').addClass('d-flex');
            } else {
                $("#current-container").css({ "height": "fit-content", "max-height": (section_current_height + section_status_span/2 < section_chat_room_height/2) ? "none" : "calc(50% - " + (section_status_span/2) + "px)" });
                $("#show-less-current").removeClass('d-flex').addClass('d-none');
            }
            message_nav_container_current.innerHTML = "";
            renderOldRooms(current_room_list, message_nav_container_current);

            is_show_all_current = true;
        }

        function showLessCurrent() {
            // console.log("show less current");
            let section_status_span = $("#current-rooms-span").height() * 2;
            let section_chat_room_height = $("div.content-container").height();
            let section_current_height = $("#current-container").height();
            let section_waiting_height = $("#waiting-container").height();
            $("#show-less-current").removeClass('d-flex').addClass('d-none');
            message_nav_container_current.innerHTML = "";
            $("#current-container").css({ "height": "fit-content", "max-height": (section_current_height + section_status_span/2 < section_chat_room_height/2) ? "none" : "calc(50% - " + (section_status_span/2) + "px)" });
            if (current_room_list.length > max_room) {
                renderOldRooms(current_room_list.slice(0, max_room), message_nav_container_current);
                $('#show-all-current').removeClass('d-none').addClass('d-flex');
            } else {
                renderOldRooms(current_room_list, message_nav_container_current);
                $('#show-all-current').removeClass('d-flex').addClass('d-none');
            }

            is_show_all_current = false;
        }

        function showAllWaiting() {
            // console.log("show all waiting");
            $("#show-all-waiting").removeClass('d-flex').addClass('d-none');
            if (is_show_all_current) {
                showLessCurrent();
            }

            let section_status_span = $("#current-rooms-span").height() * 2;
            let section_chat_room_height = $("div.content-container").height();
            let section_current_height = $("#current-container").height();
            let section_waiting_height = $("#waiting-container").height();
            if (waiting_room_list.length > max_room) {
                $("#waiting-container").css({ "height": (section_chat_room_height - section_current_height - section_status_span) + "px", "overflow-y": "auto", "max-height": "none" });
                $("#show-less-waiting").removeClass('d-none').addClass('d-flex');
            } else {
                $("#waiting-container").css({ "height": "fit-content", "max-height": (section_waiting_height + section_status_span/2 < section_chat_room_height/2) ? "none" : "calc(50% - " + (section_status_span/2) + "px)" });
                $("#show-less-waiting").removeClass('d-flex').addClass('d-none');
            }
            message_nav_container_waiting.innerHTML = "";
            renderOldRooms(waiting_room_list, message_nav_container_waiting);

            is_show_all_waiting = true;
        }

        function showLessWaiting() {
            // console.log("show less waiting");
            let section_status_span = $("#current-rooms-span").height() * 2;
            let section_chat_room_height = $("div.content-container").height();
            let section_current_height = $("#current-container").height();
            let section_waiting_height = $("#waiting-container").height();
            $("#show-less-waiting").removeClass('d-flex').addClass('d-none');
            message_nav_container_waiting.innerHTML = "";
            $("#waiting-container").css({ "height": "fit-content", "max-height": (section_waiting_height + section_status_span/2 < section_chat_room_height/2) ? "none" : "calc(50% - " + (section_status_span/2) + "px)" });
            if (waiting_room_list.length > max_room) {
                renderOldRooms(waiting_room_list.slice(0, max_room), message_nav_container_waiting);
                $('#show-all-waiting').removeClass('d-none').addClass('d-flex');
            } else {
                renderOldRooms(waiting_room_list, message_nav_container_waiting);
                $('#show-all-waiting').removeClass('d-flex').addClass('d-none');
            }

            is_show_all_waiting = false;
        }

        //Handle file input
        $(document).ready(function() {
            $('input#image').change(function() {
                var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                var input = this;

                if (input.files && input.files[0]) {
                    console.log(input.files[0])
                    // Check image file extension
                    if (allowedExtensions.test(input.files[0].name)) {

                        // Compress image
                        const options = {
                            strict: true,
                            maxWidth: 1920,
                            maxHeight: 1920,
                            quality: 0.8,
                            mimeType: 'image/jpeg',
                            success(result) {
                                console.log(result);
                                var reader = new FileReader();
                                reader.onloadend = function(e) {
                                    uploadFile(new File([result], result.name, { type: result.type }), (url) => {
                                        if (reply.check == 4) {
                                            reply.check = 3;
                                            reply.images.push(url ?? "");
                                        }
                                        addMessage(url, "image");
                                    });
                                    // addMessage("/assets/image/image" + Math.floor(Math.random() * 7 + 1) + ".jpg", "image");
                                };
                                reader.readAsDataURL(result);
                            },
                            error(e) {
                                console.error(e.message);
                            },
                        };

                        new ImageCompressor(input.files[0], options);
                    } else {
                        alert('Chỉ chấp nhận file ảnh có đuôi .jpg, .jpeg hoặc .png');
                        $(this).val('');
                    }

                    
                }
            });
        });

        /*
        *
        *   Collections/Refs && Utils
        *
        */
        // Refs
        const col_rooms = collection(fs, "chat_rooms_gozic");
        const col_messages = collection(fs, "messages");
        const col_users = collection(fs, 'users_gozic')

        // Base query
        const docRoomByRoomId = (room_id) => {
            return doc(col_rooms, room_id);
        }
        const colMessageByRoomId = (room_id) => {
            let doc_room = docRoomByRoomId(room_id);
            return collection(doc_room, 'chat');
        }

        // Add new message
        function addMessage(message, message_type="text") {
            const col_chat = collection(fs, "chat_rooms_gozic", room_id, "chat");

            const doc_chat_data = {
                "askimg": "",
                "chat": message,
                "check": reply.check,
                "id": "",
                "images": message_type == "text" ? [] : [
                    message
                ],
                "price": 0,
                "receiverId": customer_data.id,
                "receiverName": customer_data.name,
                "receiverToken": "",
                "reply": reply.reply,
                "replyimages": reply.images,
                "senderId": system_data.id,
                "senderName": system_data.name,
                "senderPhone": system_data.phone,
                "timestamp": new Date(),
                "title": ""
            };
            addDoc(col_chat, doc_chat_data);

            const update_room = {
                "lastchat": message,
                "lastid": system_data.id,
                "receiverAvatar": customer_data.avatar_url,
                "receiverId": customer_data.id,
                "receiverName": customer_data.name,
                "receiverRoleId": 1,
                "timestamp": new Date(),
                "unread": 0,
                "threadId": ""
            };
            updateDoc(docRoomByRoomId(room_id), update_room);

            resetReply();
        }

        // Sync rooms in real-time with database
        onSnapshot(query(col_rooms, orderBy('timestamp')), async (snapshot) => {
            console.log("changed")
            current_room_list = [];
            waiting_room_list = [];
            const rooms = snapshot.docs;
            // console.log(rooms)
            await Promise.all(rooms.map(async (room) => {
                console.log(room.data());
                let room_data = room.data();
                room_data.id = room.id;
                let doc_room = await getDoc(doc(fs, 'chat_rooms_gozic', room.id));
                room_data.message_content = "<span>" + shortenStringDisplay(doc_room.data().lastchat, 18) + "</span>";
                room_data.time_display = formatTimestampDisplay(doc_room.data().timestamp.seconds);
                if (doc_room.data().senderId == 0 || (doc_room.data().senderId == system_data.id && doc_room.data().senderName == system_data.name)) {
                    room_data.customer = {
                        name: doc_room.data().receiverName,
                        avatar_url: doc_room.data().receiverAvatar
                    }
                } else if (doc_room.data().receiverId == 0 || doc_room.data().receiverId == system_data.id && doc_room.data().receiverName == system_data.name) {
                    room_data.customer = {
                        name: doc_room.data().senderName,
                        avatar_url: doc_room.data().senderAvatar
                    }
                }
                // console.log(room_data);
                if (room.data().participants[1] == system_data.id) {
                    // Auto read for current selected chat room
                    if (room.id == room_id) {
                        // if (unsubscribe_message != null) unsubscribe_message();
                        // console.log(room_id);
                        const update_room_data = {
                            "unread": 0,
                        };
                        updateDoc(docRoomByRoomId(room_id), update_room_data);
                        current_room_list.push(room_data);
                    } else {
                        current_room_list.push(room_data);
                    }
                } else {
                    waiting_room_list.push(room_data);
                }
            }));
            // console.log(current_room_list, waiting_room_list)
            // message_nav_container_current.innerHTML = "";
            // message_nav_container_waiting.innerHTML = "";

            current_room_list = current_room_list.reverse();
            waiting_room_list = waiting_room_list.reverse();

            if (is_show_all_current) showAllCurrent();
            else showLessCurrent();
            if (is_show_all_waiting) showAllWaiting();
            else showLessWaiting();
        }, (error) => {
            console.log(error);
        });

        // Sync message in real-time with database
        var unsubscribe_message = null;
        function syncMessage(room_id) {
            if (unsubscribe_message != null) unsubscribe_message();
            const doc_room = doc(fs, 'chat_rooms_gozic', room_id);
            let participants = null;
            getDoc(doc_room).then((room) => {
                if (room.exists()) {
                    if (room.data().senderId == 0 || (room.data().senderId == system_data.id && room.data().senderName == system_data.name)) {
                        customer_data = {
                            id: room.data().receiverId,
                            name: room.data().receiverName,
                            avatar_url: room.data().receiverAvatar
                        }
                    } else if (room.data().receiverId == 0 || room.data().receiverId == system_data.id && room.data().receiverName == system_data.name) {
                        customer_data = {
                            id: room.data().senderId,
                            name: room.data().senderName,
                            avatar_url: room.data().senderAvatar
                        }
                    }
                
                    const update_room = {
                        "participants": [
                            customer_data.id,
                            system_data.id
                        ],
                        "unread": 0
                    };
                    participants = update_room.participants;
                    // console.log(participants)
                    avatar_list['user'] = customer_data.avatar_url;
                    updateDoc(doc_room, update_room);
                    // console.log(room_id);
                    getDocs(query(colMessageByRoomId(room_id), orderBy("timestamp"))).then((messages_doc) => {
                        const messages = messages_doc.docs;
                        // console.log(messages);
                        chat_history.innerHTML = "";
                        last_message_list = document.querySelector("#chat-history .chat-detail:last-child");
                        last_message = document.querySelector("#chat-history .chat-detail:last-child .chat-message:last-child");
                        renderOldMessage(messages, participants);
                    });
                    unsubscribe_message = onSnapshot(query(colMessageByRoomId(room_id), orderBy("timestamp")), (snapshot) => {
                        const messages = snapshot.docs;
                        // console.log(messages);
                        chat_history.innerHTML = "";
                        last_message_list = document.querySelector("#chat-history .chat-detail:last-child");
                        last_message = document.querySelector("#chat-history .chat-detail:last-child .chat-message:last-child");
                        renderOldMessage(messages, participants);
                    })
                }
            }, (error) => {
                console.log(error);
            });
        }

        // Handle reply message
        $(document).on('click', ".message-reply", function() {
            reply.id = $(this).prop("id");
            reply.name = $(this).parent().hasClass("user-message") ? customer_data.name : system_data.name;
            $("#reply-detail #reply-name").text(shortenStringDisplay(reply.name, 18));
            switch ($(this).data("message-type")) {
                case "image":
                    reply.check = 4;
                    reply.reply = "";
                    reply.images = [
                        $(this).parent(".chat-message").children("img").eq(0).prop("src")
                    ];
                    $("#reply-detail #reply-content").text("[Hình ảnh]");
                    $("#reply-image").addClass('d-show').prop("src", $(this).parent(".chat-message").children("img").eq(0).prop("src"));
                    break;
                case "text":
                    reply.check = 2;
                    reply.reply = $(this).parent(".chat-message").children("span").eq(0).text();
                    reply.images = [];
                    $("#reply-detail #reply-content").text(shortenStringDisplay(reply.reply, 30));
                    $("#reply-image").removeClass('d-show');
                    $("#chat-history").removeClass('with-reply');
                    break;
            }
            $("#chat-history").addClass('with-reply');
            $("#chat-reply").addClass('d-flex');
        })
        function resetReply() {
            reply.id = "";
            reply.reply = "";
            reply.check = 1;
            $("#reply-image").removeClass('d-show');
            $("#chat-history").removeClass('with-reply');
            $("#chat-reply").removeClass('d-flex');
        }
        $(document).on('click', "#reply-cancel", function() {
            resetReply();
        })
    </script>
    {{-- <script src="{{ asset('assets/js/markdown-it.min.js') }}"></script> --}}
@stop