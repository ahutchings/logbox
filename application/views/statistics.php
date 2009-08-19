            <div id="yui-main">
                <div class="yui-a"><div class="yui-g">

                    <div class="block">
                    	<div class="hd">
                    		<h3>Top 10 Senders</h3>
                    	</div>
                        <div class="bd">
                            <div id="messages-by-sender" style="height:220px;"></div>
                        	<script language="javascript" type="text/javascript">
                            $(function () {
                                var d1 = [
								<?php for ($i = 0; $i < count($this->messages_by_sender); $i++): ?>
								[<?php echo $i . ',' . $this->messages_by_sender[$i]['count'] ?>],
								<?php endfor ?>
                            	];

                            	var xaxis_ticks = [
   								<?php for ($i = 0; $i < count($this->messages_by_sender); $i++): ?>
								[<?php echo $i . ',"' . $this->messages_by_sender[$i]['sender'] ?>"],
								<?php endfor ?>
                               	];

                                $.plot($("#messages-by-sender"), [ d1 ], { bars: { align: "center", show: true }, xaxis: { ticks: xaxis_ticks}});
                            });
                            </script>
                        </div>
                    </div>

                    <div class="block">
                    	<div class="hd">
                    		<h3>Messages By Month</h3>
                    	</div>
                        <div class="bd">
							<div id="messages-by-month" style="height:220px;"></div>
                        	<script language="javascript" type="text/javascript">
                            $(function () {
                                var d1 = [
								<?php foreach ($this->messages_by_month as $data): ?>
								[<?php echo $data['timestamp'] * 1000 ?>, <?php echo $data['count'] ?>],
								<?php endforeach ?>
                            	]

                                $.plot($("#messages-by-month"), [ d1 ], { xaxis: { mode: "time", timeformat: "%b %y" }});
                            });
                            </script>
                        </div>
                    </div>

                </div></div>
            </div>
