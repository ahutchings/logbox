<?php include 'header.php' ?>
        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">

                    <!-- Basic block with tabs -->
                    <div class="block tabs" id="search">
                        <div class="hd">
                            <ul>
                                <li class="active"><a href="#">Search</a></li>
                                <li><a href="#">Advanced Search</a></li>
                            </ul>
                            <div class="clear"></div>
                        </div>
                        <div class="bd">
                            <form action="#" method="get">
                                <p><label for="criteria">Criteria</label>
                                    <input type="text" class="text" name="criteria" id="criteria">
                                </p>
                                <p><input type="submit" name="test4" id="test4" value="Search"></p>
                            </form>
                            <script type="text/javascript">
                            	$('#criteria').clearingInput({text: 'Enter a sender name and/or message content'});
                            </script>
                        </div>
                    </div>

                    <div class="block" id="messages">
                        <div class="hd">
                            <h2>Recent Messages<span style="float:right"><strong>1</strong> - <strong>12</strong> of <strong><?php echo Message::get_count() ?></strong></span></h2>
                        </div>
                        <div class="bd">
                        	<table>
                                <thead>
                                    <tr>
                                        <td>Protocol</td>
                                        <td>Sender</td>
                                        <td>Message</td>
                                        <td>Sent At</td>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php foreach ($this->messages as $message): ?>
                                    <tr>
                                        <td class="protocol <?php echo $message->protocol ?>"></td>
                                        <td><?php echo $message->sender ?></td>
                                        <td class="gray"><?php echo $message->content ?></td>
                                        <td class="text-right"><?php echo Logbox::fuzzy_time($message->sent_at) ?></td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>

                            <ul class="pager">
                                <li><a href="#">&#171; Prev</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">6</a></li>
                                <li><a href="#">7</a></li>
                                <li><a href="#">Next &#187;</a></li>
                            </ul>
                        </div>
                    </div>

                </div></div>
            </div>
            <div id="sidebar" class="yui-b">

                <div class="block">
                    <div class="hd">
                        <h2>Summary</h2>
                    </div>
                    <div class="bd">
                        <p>Logged messages span <strong>8</strong>&nbsp;accounts,
                        <strong>5</strong>&nbsp;protocols, and <strong>46</strong>
                        contacts. In the past <strong>3</strong>&nbsp;years,
                        <strong>5</strong>&nbsp;months, and <strong>21</strong>&nbsp;days,
                        you have sent <strong>12,125</strong>&nbsp;messages
                        and received <strong>13,256</strong>&nbsp;messages.</p>
                        <p>The last message import occured <strong>4</strong>&nbsp;hours,
                        <strong>21</strong>&nbsp;minutes ago.</p>
                    </div>
                </div>
            </div>
        </div>
<?php include 'footer.php' ?>
