            <div id="yui-main">
                <div class="yui-a"><div class="yui-g">
                	<form action="/" method="get" id="messages-form">

                    <div id="search">
                            <p>
                            	<label for="criteria">Criteria</label>
                                <input type="text" class="text" name="criteria" id="criteria"<?php if (isset($criteria)): ?><?php echo ' value="' . $criteria . '"'; ?><?php endif ?>>
                           		<input type="submit" value="Search Messages">
                           	</p>
                    </div>

                    <div class="block" id="messages">
                        <div class="hd">
                            <span>
                            	<select name="sender" id="sender">
                            		<option value="">Show all senders</option>
                            		<?php //foreach ($senders as $sender): ?>
                            		<option<?php if (false && isset($this->sender) && $this->sender == $sender): ?><?php echo ' selected="selected"'; ?><?php endif ?>><?php //$this->eprint($sender) ?></option>
                            		<?php //endforeach ?>
                            	</select>
                            	<select name="dates" id="dates">
                            		<option value="">Show all dates</option>
                            		<?php //foreach ($dates as $date): ?>
                            		<option<?php if (false && isset($this->date) && $this->date == $date): ?><?php echo ' selected="selected"'; ?><?php endif ?>><?php //echo $date ?></option>
                            		<?php //endforeach ?>
                            	</select>
                        	</span>
                            <span style="float:right">
                            	<?php //echo $pager ?>
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
                                	<?php foreach ($messages as $message): ?>
                                    <tr>
                                        <td class="protocol <?php echo $message->conversation->account->protocol->name ?>"></td>
                                        <td><?php echo $message->sender ?></td>
                                        <td class="gray"><?php echo $message->content ?></td>
                                        <td class="text-right"><?php echo date::fuzzy_time($message->sent_at) ?></td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    </form>
                </div></div>
            </div>
