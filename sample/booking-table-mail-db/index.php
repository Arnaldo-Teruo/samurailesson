<?php
/**
 * セッションスタート
 */
session_start();

/**
 * セッションにデータがあれば代入して無ければ空配列を代入
 */
$post   = isset($_SESSION['form']) ? $_SESSION['form'] : [];
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];

/**
 * セッション内の各フォームデータを変数として初期化
 */
$selectYear  = empty($post['selectYear']) ? "" : $post['selectYear'];
$selectMonth = empty($post['selectMonth']) ? "" : $post['selectMonth'];
$selectDay   = empty($post['selectDay']) ? "" : $post['selectDay'];
$selectWeek  = empty($post['selectWeek']) ? "" : $post['selectWeek'];
$plan        = empty($post['plan']) ? "" : $post['plan'];
$planActive  = empty($post['planActive']) ? "" : $post['planActive'];
$planTime    = empty($post['planTime']) ? "" : $post['planTime'];
$startTime   = empty($post['startTime']) ? "" : $post['startTime'];
$endTime     = empty($post['endTime']) ? "" : $post['endTime'];
$name        = empty($post['name']) ? "" : $post['name'];
$email       = empty($post['email']) ? "" : $post['email'];
$memo        = empty($post['memo']) ? "" : $post['memo'];

require_once 'functions.php';
require_once 'gcal-api.php';
date_default_timezone_set('Asia/Tokyo');
$now           = date('Y-m-d');
$past          = date('Y-m-d', strtotime('-7 day', time()));
$today         = date('Ymd' . convert2dig($iniStart) . '0000');
$todayUnix     = strtotime($today);
$todayLast     = date('Ymd' . convert2dig($iniEnd) . '0000');
$todayLastUnix = strtotime($todayLast);
$timeMin       = $now . 'T00:00:00+0900';
$timeMinUnix   = strtotime($timeMin);
$timeMaxUnix   = strtotime('+' . $span . ' day', $timeMinUnix);
$timeMax       = date('Y-m-d', $timeMaxUnix); //マイナスに変更したため timeMax < timeMin
$timeMax       = $timeMax . 'T23:59:00+0900';
$optParams     = array(
	// 'maxResults' => 10,
	'timeZone'     => 'Asia/Tokyo',
	'orderBy'      => 'startTime',
	'singleEvents' => true,
	'timeMin'      => $timeMin,
	'timeMax'      => $timeMax
);
$results = $service->events->listEvents($calendarId, $optParams);
$events  = $results->getItems();
if (isset($events)) :
	$ngsArr = array();
	foreach ($events as $k => $v) {
		$title = empty($v->getSummary()) ? "no title" : $v->getSummary();
		if ($title === $closeKey) {
			$start       = $v->start->date; // 2020-03-10
			$ngStart     = $start . 'T' . convert2dig($iniStart) . ':00:00+0900';
			$ngEnd       = $start . 'T' . convert2dig($iniEnd) . ':00:00+0900';
			$ngStartUnix = strtotime($ngStart);
			$ngEndUnix   = strtotime($ngEnd);
			$ngDiff      = $ngEndUnix - $ngStartUnix;
			$ngDiffMin   = $ngDiff / 60;
			$ngDiffNum   = $ngDiffMin / $divideMin;
			$ngDiffArr   = array();
			for ($i = 0; $i < $ngDiffNum; $i++) {
				$minute      = $divideMin * $i;
				$ngDiffArr[] = strtotime('+' . $minute . ' minute', $ngStartUnix);
			}
			$ngsArr[] = $ngDiffArr;
    }else{
	    $start       = $v->start->dateTime; // 2020-03-10T10:00:00+09:00
	    $end         = $v->end->dateTime; // 2020-03-10T11:00:00+09:00
			$ngStartUnix = strtotime($start);
			$ngEndUnix   = strtotime($end);
			$ngDiff      = $ngEndUnix - $ngStartUnix;
			$ngDiffMin   = $ngDiff / 60;
			$ngDiffNum   = $ngDiffMin / $divideMin;
			$ngDiffArr   = array();
			for ($i=0; $i < $ngDiffNum; $i++) {
				$minute      = $divideMin * $i;
				$ngDiffArr[] = strtotime('+' . $minute . ' minute', $ngStartUnix);
			}
			$ngsArr[] = $ngDiffArr;
    }
	}
	$ngsArr2 = array();
	foreach ($ngsArr as $k => $v) {
		foreach ($v as $k2 => $v2) {
			$ngsArr2[] = $v2;
		}
	}
	for ($i = 0; $i < $span; $i++) {
		$iniDayLastUnix = strtotime('+' . $i . ' day', $todayLastUnix);
		$ngsArr2[]      = $iniDayLastUnix;
	}
endif;
require_once 'header.php';
?>
<div class="text-center pb-4">
	<a href="users.php" class="btn btn-info">ユーザー一覧</a>
</div>

<div id="app">

	<?php if (isset($errors) && count($errors) > 0) { ?>
		<section class="errors">
			<div class="container">
				<div class="alert alert-warning text-center">
					入力ミスがあるようです
				</div>
			</div>
		</section>
	<?php } ?>

	<section class="selectMenu">
		<div class="container">
			<div class="card border-top">
				<div class="card-body">
					<div class="step">Step.1</div>
					<h2>メニューの選択</h2>
					<p>クリックすると選択状態になります</p>
					<div class="row row-cols-1 row-cols-lg-3">
						<div class="col py-1" v-for="v in plan">
							<div class="card card-hover" :class="activeMenu(v.slug)" @click="clickMenu(v)">
								<div class="card-header d-flex justify-content-between">
									<span v-text="v.title"></span><span v-text="'￥' + addDigits(v.price)"></span>
								</div>
								<div class="card-body" v-text="v.desc"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="timetable">
		<div class="container">
			<div class="card border-top">
				<div class="card-body">
					<div class="step">Step.2</div>
					<h2>時間を選択</h2>
					<p>ピンク色のセルは選択できません</p>
					<div class="table-responsive">
						<table class="table table-bordered table-timetable" :class="{ 'disabled': judgePlanActive }">
							<thead>
								<tr>
									<th class="th1"></th>
									<?php
									$todayYmd = date('m/d', $todayUnix);
									$idArr    = array($todayUnix);
									$dateArr  = array($todayYmd);
									for ($i = 0; $i < $iniDivide; $i++) {
										$todayUnix = strtotime('+' . $divideMin . ' minute', $todayUnix);
										$todayYmd  = date('m/d', $todayUnix);
										$idArr[]   = $todayUnix;
										$dateArr[] = $todayYmd;
									}
									?>
									<?php for ($i = 0; $i < $span; $i++) { ?>
										<?php
											$iniDayUnix = strtotime('+' . $i . ' day', $todayUnix);
											$iniDayYm   = date('n/j', $iniDayUnix);
											$iniDayW    = date('w', $iniDayUnix);
											$iniDayW    = get_week_kanji($iniDayW);
										?>
										<th class="th2">
											<div><?php echo $iniDayYm; ?></div>
											<small><?php echo $iniDayW; ?></small>
										</th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($idArr as $k => $v) :
									if (array_key_last($idArr) == $k) { ?>
										<tr>
											<?php $thisTime = date('H:i', $v); ?>
											<th class="th3">
												<div class="thTime"><?php echo $thisTime; ?></div>
											</th>
											<?php for ($i = 0; $i < $span; $i++) : ?>
												<td
													v-on:mouseover="hoverEffect(<?php echo $nextDayUnix; ?>)"
													v-on:mouseleave="hoverLeave()"
													:class="{ 'okTd': hoverJudge(<?php echo $nextDayUnix; ?>), 'okClick': clickJudge(<?php echo $nextDayUnix; ?>) }" 
													id="<?php echo $nextDayUnix; ?>"
													class="td1"
												>
												</td>
											<?php endfor; ?>
										</tr>
									<?php } else { ?>
										<tr>
											<?php $thisTime = date('H:i', $v); ?>
											<th class="th3">
												<div class="thTime"><?php echo $thisTime; ?></div>
											</th>
											<?php for ($i = 0; $i < $span; $i++) :
												$nextDayUnix   = strtotime('+' . $i . 'day', $v);
												$flagOpenClose = 1;
												foreach ($ngsArr as $v2) {
													foreach ($v2 as $v3) {
														if ($v3 == $nextDayUnix) {
															$flagOpenClose = 0;
														}
													}
												}
												if ($flagOpenClose) { ?>
													<td
														v-on:mouseover="hoverEffect(<?php echo $nextDayUnix; ?>)"
														v-on:mouseleave="hoverLeave()"
														v-on:click="setStartEndTime(<?php echo $nextDayUnix; ?>)"
														:class="{ 'okTd': hoverJudge(<?php echo $nextDayUnix; ?>), 'okClick': clickJudge(<?php echo $nextDayUnix; ?>) }" 
														id="<?php echo $nextDayUnix; ?>"
														class="td2"
													>
														<button class="timeSubmit"></button>
														<input type="hidden" name="selectedPlan" v-model="planActive">
														<input type="hidden" name="unixTime" value="<?php echo $nextDayUnix; ?>">
													</td>
												<?php } else { ?>
													<td class="cellClose"></td>
												<?php } ?>
											<?php
											endfor; ?>
										</tr>
								<?php }
								endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="confirm">
		<div class="container">
			<div class="card border-top">
				<div class="card-body">
					<div class="step">Step.3</div>
					<h2 class="mb-4">確認</h2>
					<div class="row mt-2 pb-3">
						<div class="col-12 col-md-3">
							<h3>メニュー</h3>
						</div>
						<div class="col-12 col-md-9">
							<h4 v-if="planActiveTitle" v-text="planActiveTitle"></h4>
						</div>
					</div>
					<div class="row mt-2 pb-3">
						<div class="col-12 col-md-3">
							<h3>日時</h3>
						</div>
						<div class="col-12 col-md-9">
							<h4 v-if="month && day"><span v-text="year + '年 ' + month + '月 ' + day + '日（' + week + '）'"></span></h4>
							<h5 v-if="startTime && endTime" v-text="startTime + ' ～ ' + endTime"></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="reserveForm">
		<div class="container">
			<div class="card border-top">
				<div class="card-body">
					<div class="step">Step.4</div>
					<h2 class="mb-4">情報入力</h2>
					<div class="row mt-2">
						<div class="col-12 col-md-3">
							<h3>お名前</h3>
						</div>
						<div class="col-12 col-md-9">
							<div class="form-group">
								<input
									type="text"
									id="name"
									name="name"
									v-model="name"
									class="form-control"
								>
							</div>
							<?php if (isset($errors['name']) && $errors['name'] === 'blank') { ?>
								<p class="text-danger">※必須項目です</p>
							<?php } ?>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-12 col-md-3">
							<h3>メールアドレス</h3>
						</div>
						<div class="col-12 col-md-9">
							<div class="form-group">
								<input
									type="email"
									id="email"
									name="email"
									v-model="email"
									class="form-control"
								>
							</div>
							<?php if (isset($errors['email']) && $errors['email'] === 'blank') { ?>
								<p class="text-danger">※必須項目です</p>
							<?php } ?>
							<?php if (isset($errors['email']) && $errors['email'] === 'email') { ?>
								<p class="text-danger">※メールアドレスの形式ではないようです</p>
							<?php } ?>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-12 col-md-3">
							<h3>コメント</h3>
						</div>
						<div class="col-12 col-md-9">
							<div class="form-group">
								<textarea
									name="memo"
									v-model="memo"
									rows="5"
									class="form-control"
								>
								</textarea>
							</div>
						</div>
					</div>
					<div class="d-flex justify-content-center my-4">
						<form action="validate.php" method="post">
							<button type="button" @click="clear()" class="btn btn-secondary text-white mr-5">クリア</button>
							<button type="submit" class="btn btn-danger" :disabled="reserveActive">予約する</button>
							<input type="hidden" name="selectYear" v-model="year">
							<input type="hidden" name="selectMonth" v-model="month">
							<input type="hidden" name="selectDay" v-model="day">
							<input type="hidden" name="selectWeek" v-model="week">
							<input type="hidden" name="plan" v-model="planActiveTitle">
							<input type="hidden" name="planActive" v-model="planActive">
							<input type="hidden" name="planTime" v-model="selectedPlanTime">
							<input type="hidden" name="startTime" v-model="startTime">
							<input type="hidden" name="endTime" v-model="endTime">
							<input type="hidden" name="name" v-model="name">
							<input type="hidden" name="email" v-model="email">
							<input type="hidden" name="memo" v-model="memo">
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

</div><!-- /#app -->

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
	var app = new Vue({
		el: '#app',
		data: {
			plan: <?php include_once 'plan.json'; ?>,
			planActive: '<?php echo $planActive; ?>',
			planActiveTitle: '<?php echo $plan; ?>',
			hoverActive: [],
			closed: <?php echo json_encode($ngsArr2); ?>,
			selectedPlanTime: '<?php echo $planTime; ?>',
			startTime: '<?php echo $startTime; ?>',
			endTime: '<?php echo $endTime; ?>',
			judgePlanActive: true,
			reserveActive: true,
			memo: '<?php echo $memo; ?>',
			year: '<?php echo $selectYear; ?>',
			month: '<?php echo $selectMonth; ?>',
			day: '<?php echo $selectDay; ?>',
			week: '<?php echo $selectWeek; ?>',
			name: '<?php echo $name; ?>',
			email: '<?php echo $email; ?>'
		},
		mounted: function() {
			this.setPlanActive();
			this.switchReserveActive();
		},
		methods: {
			setPlanActive() {
				if (this.planActive) {
					this.judgePlanActive = false;
					this.setPlanTime();
				}
			},
			hoverEffect(e) {
				let planTime = ((this.selectedPlanTime / <?php echo $divideMin; ?>) - 1) * 60 * <?php echo $divideMin; ?>;
				let start    = new Date(e * 1000);
				let end      = new Date((e + planTime) * 1000);
				let diff     = end - start;
				let diffNum  = diff / 1000 / 60 / <?php echo $divideMin; ?>;
				let diffArr  = [e];
				for (let i = 0; i < diffNum; i++) {
					let minute   = <?php echo $divideMin; ?> * (i + 1);
					let pushTime = (e * 1000) + (minute * 60 * 1000);
					pushTime     = pushTime / 1000;
					diffArr.push(pushTime);
				}
				this.hoverActive = diffArr;
			},
			hoverLeave() {
				this.hoverActive = '';
			},
			hoverJudge(e) {
				if (this.hoverActive.indexOf(e) >= 0) {
					for (let key in this.hoverActive) {
						if (this.closed.indexOf(this.hoverActive[key]) >= 0) {
							return false;
						}
					}
					return true;
				}
				return false;
			},
			clickJudge(e) {
				if (this.judgePlanActive) {
					return false;
				}
				let planTime = ((this.selectedPlanTime / <?php echo $divideMin; ?>) - 1) * 60 * <?php echo $divideMin; ?>;
				let start    = new Date(e * 1000);
				let end      = new Date((e + planTime) * 1000);
				let diff     = end - start;
				let diffNum  = diff / 1000 / 60 / <?php echo $divideMin; ?>;
				let diffArr  = [e];
				for (let i = 0; i < diffNum; i++) {
					let minute   = <?php echo $divideMin; ?> * (i + 1);
					let pushTime = (e * 1000) + (minute * 60 * 1000);
					pushTime     = pushTime / 1000;
					diffArr.push(pushTime);
				}
				for (let key in diffArr) {
					if (this.closed.indexOf(diffArr[key]) >= 0) {
						return false;
					}
				}
				return true;
			},
			activeMenu: function(v) {
				if (this.planActive === v) {
					return 'active';
				}
				return false;
			},
			clickMenu: function(v) {
				this.planActive      = v.slug;
				this.judgePlanActive = false;
				this.setPlanTime();
				this.planActiveTitle = v.title;
			},
			setPlanTime: function() {
				for (let k in this.plan) {
					if (this.planActive === this.plan[k].slug) {
						this.selectedPlanTime = this.plan[k].time;
					}
				}
			},
			setEndTime: function(e) {
				let time       = new Date(e * 1000 + this.selectedPlanTime * 1000 * 60);
				let endHours   = this.zeroPadding(time.getHours());
				let endMinutes = this.zeroPadding(time.getMinutes());
				this.endTime   = endHours + ':' + endMinutes;
			},
			setStartTime: function(e) {
				this.year         = new Date(e * 1000).getFullYear();
				this.month        = new Date(e * 1000).getMonth() + 1;
				this.day          = new Date(e * 1000).getDate();
				let startTimeHour = new Date(e * 1000).getHours();
				startTimeHour     = ('0' + startTimeHour).slice(-2);
				let startTimeMin  = new Date(e * 1000).getMinutes();
				startTimeMin      = ('0' + startTimeMin).slice(-2);
				this.startTime    = startTimeHour + ':' + startTimeMin;
			},
			setWeek: function(){
				let date         = new Date(this.year, this.month - 1, this.day);
				let dayOfWeek    = date.getDay();
				let dayOfWeekStr = ["日", "月", "火", "水", "木", "金", "土"][dayOfWeek];
				this.week        = dayOfWeekStr;
			},
			setStartEndTime(e){
				this.setStartTime(e);
				this.setEndTime(e);
				this.setWeek();
			},
			addDigits: function(v){
				return Number(v).toLocaleString();
			},
			zeroPadding: function(v){
				return ('0' + v).slice(-2);
			},
			switchReserveActive: function() {
				if (this.planActive != "" && this.startTime != "" && this.endTime != "") {
					this.reserveActive = false;
				} else {
					this.reserveActive = true;
				}
			},
			clear: function(){
				this.planActive = '';
				this.planActiveTitle = '';
				this.selectedPlanTime = '';
				this.startTime = '';
				this.endTime = '';
				this.judgePlanActive = true;
				this.reserveActive = true;
				this.memo = '';
				this.year = '';
				this.month = '';
				this.day = '';
				this.week = '';
				this.name = '';
				this.email = '';
			}
		},
		watch: {
			planActive: function(v) {
				this.switchReserveActive();
				if (v.length > 0) {
					this.isStartDisabled = false;
				} else {
					this.isStartDisabled = true;
				}
			},
			startTime: function(v) {
				this.switchReserveActive();
			},
			endTime: function(v) {
				this.switchReserveActive();
			}
		}
	})
</script>

<?php require_once 'footer.php'; ?>