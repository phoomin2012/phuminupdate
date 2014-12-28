<style>
.jfk-button{
	-webkit-border-radius:2px;
	-moz-border-radius:2px;
	border-radius:2px;
	cursor:default;
	font-size:11px;
	font-weight:bold;
	text-align:center;
	white-space:nowrap;
	margin-right:16px;
	height:27px;
	line-height:27px;
	min-width:54px;
	outline:0;
	padding:0 8px;
}
.jfk-button-hover{
	-webkit-box-shadow:0 1px 1px rgba(0,0,0,.1);
	-moz-box-shadow:0 1px 1px rgba(0,0,0,.1);
	box-shadow:0 1px 1px rgba(0,0,0,.1);
}
.jfk-button-selected{
	-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);
	-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);
	box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);
}
.jfk-button .jfk-button-img{
	margin-top:-3px;vertical-align:middle;
}
.jfk-button-label{margin-left:5px}
.jfk-button-narrow{min-width:34px;padding:0}
.jfk-button-collapse-left,.jfk-button-collapse-right{z-index:1}
.jfk-button-collapse-left.jfk-button-disabled{z-index:0}
.jfk-button-checked.jfk-button-collapse-left,.jfk-button-checked.jfk-button-collapse-right{
	z-index:2}
	.jfk-button-collapse-left:focus,.jfk-button-collapse-right:focus,.jfk-button-hover.jfk-button-collapse-left,.jfk-button-hover.jfk-button-collapse-right{
	z-index:3;
}
.jfk-button-collapse-left{
	margin-left:-1px;
	-moz-border-radius-bottomleft:0;
	-moz-border-radius-topleft:0;
	-webkit-border-bottom-left-radius:0;
	-webkit-border-top-left-radius:0;border-bottom-left-radius:0;
	border-top-left-radius:0;
}
.jfk-button-collapse-right{
	margin-right:0;
	-moz-border-radius-topright:0;
	-moz-border-radius-bottomright:0;
	-webkit-border-top-right-radius:0;
	-webkit-border-bottom-right-radius:0;
	border-top-right-radius:0;
	border-bottom-right-radius:0;
}
.jfk-button.jfk-button-disabled:active{
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	box-shadow:none;
}
.jfk-button-action{
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	box-shadow:none;
	background-color:#4d90fe
	;background-image:-webkit-linear-gradient(top,#4d90fe,#4787ed);
	background-image:-moz-linear-gradient(top,#4d90fe,#4787ed);
	background-image:-ms-linear-gradient(top,#4d90fe,#4787ed);
	background-image:-o-linear-gradient(top,#4d90fe,#4787ed);
	background-image:linear-gradient(top,#4d90fe,#4787ed);
	border:1px solid #3079ed;
	color:#fff;
}
.jfk-button-action.jfk-button-hover{
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	box-shadow:none;
	background-color:#357ae8;
	background-image:-webkit-linear-gradient(top,#4d90fe,#357ae8);
	background-image:-moz-linear-gradient(top,#4d90fe,#357ae8);
	background-image:-ms-linear-gradient(top,#4d90fe,#357ae8);
	background-image:-o-linear-gradient(top,#4d90fe,#357ae8);
	background-image:linear-gradient(top,#4d90fe,#357ae8);
	border:1px solid #2f5bb7;
	border-bottom-color:#2f5bb7;
}
.jfk-button-action:focus{
	-webkit-box-shadow:inset 0 0 0 1px #fff;
	-moz-box-shadow:inset 0 0 0 1px #fff;
	box-shadow:inset 0 0 0 1px #fff;
	border:1px solid #fff;
	border:rgba(0,0,0,0) solid 1px;
	outline:1px solid #4d90fe;
	outline:rgba(0,0,0,0) 0;
}
.jfk-button-action.jfk-button-clear-outline{
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	box-shadow:none;
	outline:none;
}
.jfk-button-action:active{
	-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
	-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
	box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
	background:#357ae8;
	border:1px solid #2f5bb7;
	border-top:1px solid #2f5bb7
}
.jfk-button-action.jfk-button-disabled{
	background:#4d90fe;
	filter:alpha(opacity=50);
	opacity:.5
}
.jfk-button-contrast{
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	box-shadow:none;
	background-color:#f5f5f5;
	background-image:-webkit-linear-gradient(top,#f5f5f5,#f1f1f1);
	background-image:-moz-linear-gradient(top,#f5f5f5,#f1f1f1);
	background-image:-ms-linear-gradient(top,#f5f5f5,#f1f1f1);
	background-image:-o-linear-gradient(top,#f5f5f5,#f1f1f1);
	background-image:linear-gradient(top,#f5f5f5,#f1f1f1);
	color:#444;
	border:1px solid #dcdcdc;
	border:1px solid rgba(0,0,0,0.1);
}
.jfk-button-contrast.jfk-button-hover,.jfk-button-contrast.jfk-button-clear-outline.jfk-button-hover{
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	box-shadow:none;
	background-color:#f8f8f8;
	background-image:-webkit-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image:-moz-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image:-ms-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image:-o-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image:linear-gradient(top,#f8f8f8,#f1f1f1);
	border:1px solid #c6c6c6;
	color:#333;
}
.jfk-button-contrast:active,.jfk-button-contrast.jfk-button-hover:active{
	-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,.1);
	-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,.1);
	box-shadow:inset 0 1px 2px rgba(0,0,0,.1);
	background:#f8f8f8;
}
.jfk-button-contrast.jfk-button-selected,.jfk-button-contrast.jfk-button-clear-outline.jfk-button-selected{
	background-color:#eee;
	background-image:-webkit-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image:-moz-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image:-ms-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image:-o-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image:linear-gradient(top,#f8f8f8,#f1f1f1);
	border:1px solid #ccc;
	color:#333;
}
.jfk-button-contrast.jfk-button-checked,.jfk-button-contrast.jfk-button-clear-outline.jfk-button-checked{
	-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,.1);
	-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,.1);
	box-shadow:inset 0 1px 2px rgba(0,0,0,.1);
	background-color:#eee;
	background-image:-webkit-linear-gradient(top,#eee,#e0e0e0);
	background-image:-moz-linear-gradient(top,#eee,#e0e0e0);
	background-image:-ms-linear-gradient(top,#eee,#e0e0e0);
	background-image:-o-linear-gradient(top,#eee,#e0e0e0);
	background-image:linear-gradient(top,#eee,#e0e0e0);
	border:1px solid #ccc;
	color:#333;
}
.jfk-button-contrast:focus{
	border:1px solid #4d90fe;
	outline:none;
}
.jfk-button-contrast.jfk-button-clear-outline{
	border:1px solid #dcdcdc;
	outline:none;
}
.jfk-button-contrast.jfk-button-disabled{
	background:#fff;
	border:1px solid #f3f3f3;
	border:1px solid rgba(0,0,0,0.05);
	color:#b8b8b8;
}
.jfk-button-contrast .jfk-button-img{
	opacity:.55;
}
.jfk-button-contrast.jfk-button-checked .jfk-button-img,.jfk-button-contrast.jfk-button-selected .jfk-button-img,.jfk-button-contrast.jfk-button-hover .jfk-button-img{
	opacity:.9;
}
.jfk-button-contrast.jfk-button-disabled .jfk-button-img{
	filter:alpha(opacity=33);
	opacity:.333;
}
.jfk-button-default{
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	box-shadow:none;
	background-color:#3d9400;
	background-image:-webkit-linear-gradient(top,#3d9400,#398a00);
	background-image:-moz-linear-gradient(top,#3d9400,#398a00);
	background-image:-ms-linear-gradient(top,#3d9400,#398a00);
	background-image:-o-linear-gradient(top,#3d9400,#398a00);
	background-image:linear-gradient(top,#3d9400,#398a00);
	border:1px solid #29691d;color:#fff;
	text-shadow:0 1px rgba(0,0,0,0.1);
}
.jfk-button-default.jfk-button-hover{
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	box-shadow:none;
	background-color:#368200;
	background-image:-webkit-linear-gradient(top,#3d9400,#368200);
	background-image:-moz-linear-gradient(top,#3d9400,#368200);
	background-image:-ms-linear-gradient(top,#3d9400,#368200);
	background-image:-o-linear-gradient(top,#3d9400,#368200);
	background-image:linear-gradient(top,#3d9400,#368200);
	border:1px solid #2d6200;
	border-bottom:1px solid #2d6200;
	text-shadow:0 1px rgba(0,0,0,0.3);
}
.jfk-button-default:focus{
	-webkit-box-shadow:inset 0 0 0 1px #fff;
	-moz-box-shadow:inset 0 0 0 1px #fff;
	box-shadow:inset 0 0 0 1px #fff;
	border:1px solid #fff;
	border:rgba(0,0,0,0) solid 1px;
	outline:1px solid #3d9400;
	outline:rgba(0,0,0,0) 0;
}
.jfk-button-default.jfk-button-clear-outline{
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	box-shadow:none;
	outline:none;
}
.jfk-button-default:active{
	-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
	-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
	box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
	background:#368200;
	border:1px solid #2d6200;
	border-top:1px solid #2d6200;
}
.jfk-button-default.jfk-button-disabled{
	background:#3d9400;
	filter:alpha(opacity=50);
	opacity:.5;
}
.jfk-button-primary{
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	box-shadow:none;
	background-color:#d14836;
	background-image:-webkit-linear-gradient(top,#dd4b39,#d14836);
	background-image:-moz-linear-gradient(top,#dd4b39,#d14836);
	background-image:-ms-linear-gradient(top,#dd4b39,#d14836);
	background-image:-o-linear-gradient(top,#dd4b39,#d14836);
	background-image:linear-gradient(top,#dd4b39,#d14836);
	border:1px solid transparent;color:#fff;
	text-shadow:0 1px rgba(0,0,0,0.1);
	text-transform:uppercase;
}
.jfk-button-primary.jfk-button-hover{
	-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.2);
	-moz-box-shadow:0 1px 1px rgba(0,0,0,0.2);
	box-shadow:0 1px 1px rgba(0,0,0,0.2);
	background-color:#c53727;
	background-image:-webkit-linear-gradient(top,#dd4b39,#c53727);
	background-image:-moz-linear-gradient(top,#dd4b39,#c53727);
	background-image:-ms-linear-gradient(top,#dd4b39,#c53727);
	background-image:-o-linear-gradient(top,#dd4b39,#c53727);
	background-image:linear-gradient(top,#dd4b39,#c53727);
	border:1px solid #b0281a;
	border-bottom-color:#af301f;
}
.jfk-button-primary:focus{
	-webkit-box-shadow:inset 0 0 0 1px #fff;
	-moz-box-shadow:inset 0 0 0 1px #fff;
	box-shadow:inset 0 0 0 1px #fff;
	border:1px solid #fff;
	border:rgba(0,0,0,0) solid 1px;
	outline:1px solid #d14836;
	outline:rgba(0,0,0,0) 0;
}
.jfk-button-primary.jfk-button-clear-outline{
	-webkit-box-shadow:none;-moz-box-shadow:none;
	box-shadow:none;outline:none;
}
.jfk-button-primary:active{
	-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
	-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
	box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
	background-color:#b0281a;
	background-image:-webkit-linear-gradient(top,#dd4b39,#b0281a);
	background-image:-moz-linear-gradient(top,#dd4b39,#b0281a);
	background-image:-ms-linear-gradient(top,#dd4b39,#b0281a);
	background-image:-o-linear-gradient(top,#dd4b39,#b0281a);
	background-image:linear-gradient(top,#dd4b39,#b0281a);
	border:1px solid #992a1b;border-top:1px solid #992a1b;
}
.jfk-button-primary.jfk-button-disabled{
	background:#d14836;
	filter:alpha(opacity=50);
	opacity:.5;
}
.jfk-button-standard .scb-button-icon{
	opacity:.55;
}
.jfk-button-standard.jfk-button-checked .scb-button-icon,.jfk-button-standard.jfk-button-selected .scb-button-icon,.jfk-button-standard.jfk-button-hover .scb-button-icon{
	opacity:.9;
}
.jfk-button-standard.jfk-button-disabled .scb-button-icon{
	opacity:.333;
}
body::-webkit-scrollbar-track-piece{
	background-clip:padding-box;
	background-color:#f5f5f5;
	border:solid #fff;
	border-width:0 0 0 3px;
	box-shadow:inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);
}
body::-webkit-scrollbar-track-piece:horizontal{
	border-width:3px 0 0;
	box-shadow:inset 0 1px 0 rgba(0,0,0,.14),inset 0 -1px 0 rgba(0,0,0,.07);
}
body::-webkit-scrollbar-thumb{
	border-width:1px 1px 1px 5px;
}
body::-webkit-scrollbar-thumb:horizontal{
	border-width:5px 1px 1px;
}
body::-webkit-scrollbar-corner{
	background-clip:padding-box;
	background-color:#f5f5f5;
	border:solid #fff;
	border-width:3px 0 0 3px;
	box-shadow:inset 1px 1px 0 rgba(0,0,0,.14);
}
body{
	font:normal 13px arial,sans-serif;

}
</style>