<?php include 'header.php' ?>
        <div id="bd">
            <div id="yui-main">
                <div class="yui-a"><div class="yui-g">

                    <div class="block">
                        <div class="bd">
                            <table id="messages-by-sender">
                            	<caption>Messages By Sender</caption>
                                <thead>
                                    <tr>
                                    	<td></td>
                                        <th>Messages Sent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php foreach ($this->messages_by_sender as $data): ?>
                                    <tr>
                                        <th><?php $this->eprint($data['sender']) ?></th>
                                        <td><?php echo $data['count'] ?></td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div></div>
            </div>
        </div>
<?php include 'footer.php' ?>
