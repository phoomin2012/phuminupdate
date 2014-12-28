<div class="glass">
	ติดตามข่าวการอัพเดรตได้ <a href="http://fb.com/phoomin2012" target="_blank">ที่นี่</a>
</div>

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">สถิติการใช้งาน</h3>
    </div>
    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
    
    </div>
</div>
<style>
.glass{
	margin-top:-19px;
	margin-left:-15px;
	padding:50px;
	color:#BEBEBE;
	position:absolute;
	-webkit-opacity:70%;
	-moz-opacity:70%;
	-ms-opacity:70%;
	-o-opacity:70%;
	opacity:70%;
	width:100%;
	min-height:465px;
	text-align:center;
	vertical-align:central;
	font-size:48px;
	z-index:4000;
	
	background-image: url(img/mc.png);
	background-repeat: repeat;
}
</style>
<script>
var area = new Morris.Area({
	element: 'revenue-chart',
	resize: true,
	data: [
		{y: '2014-04-23', item1: 2, item2: 2, item3: 2},
		{y: '2014-04-24', item1: 7, item2: 5, item3: 3},
		{y: '2014-04-25', item1: 10, item2: 7, item3: 100},
		{y: '2014-04-26', item1: 30, item2: 23, item3: 120},
	],
	xkey: 'y',
	ykeys: ['item1', 'item2', 'item3'],
	labels: ['การใช้งาน', 'การอัพเดรต', 'การดาวห์โหลด'],
	lineColors: ['#a0d0e0', '#3c8dbc', '#2c642b'],
	hideHover: 'auto'
});
</script>