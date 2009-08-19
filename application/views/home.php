            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">
                	<form action="/" method="get" id="messages-form">

                    <div id="search">
                            <p>
                            	<label for="criteria">Criteria</label>
                                <input type="text" class="text" name="criteria" id="criteria"<?php if (isset($this->criteria)): ?><?php echo ' value="' . $this->criteria . '"'; ?><?php endif ?>>
                           		<input type="submit" value="Search Messages">
                           	</p>
                    </div>

                    <div class="block" id="messages">
                        <div class="hd">
                            <span>
                            	<select name="sender" id="sender">
                            		<option value="">Show all senders</option>
                            		<?php //foreach ($this->senders as $sender): ?>
                            		<option<?php if (false && isset($this->sender) && $this->sender == $sender): ?><?php echo ' selected="selected"'; ?><?php endif ?>><?php //$this->eprint($sender) ?></option>
                            		<?php //endforeach ?>
                            	</select>
                            	<select name="dates" id="dates">
                            		<option value="">Show all dates</option>
                            		<?php //foreach ($this->dates as $date): ?>
                            		<option<?php if (false && isset($this->date) && $this->date == $date): ?><?php echo ' selected="selected"'; ?><?php endif ?>><?php //echo $date ?></option>
                            		<?php //endforeach ?>
                            	</select>
                        	</span>
                            <span style="float:right">
                            	<?php //echo $this->pager ?>
                            </span>
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
                                	<?php //foreach ($this->messages as $message): ?>
                                    <tr>
                                        <td class="protocol <?php //echo $message->protocol ?>"></td>
                                        <td><?php //echo $message->sender ?></td>
                                        <td class="gray"><?php //echo $message->content ?></td>
                                        <td class="text-right"><?php //echo Logbox::fuzzy_time($message->sent_at) ?></td>
                                    </tr>
                                    <?php //endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    </form>
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
