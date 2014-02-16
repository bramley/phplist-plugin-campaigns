<p>This page lets you specify subscribers who have already been sent the campaign, but who you want to send to again.</p>
<p>To achieve this the plugin will remove rows from the usermessage table for the specified subscribers, so it then appears that
they have not yet been sent the campaign. Those subscribers will then be included when the campaign is next sent.<p>

<table>
<tr >
<td>Campaign</td>
<td>The campaign ID and subject</td>
</tr>
<tr >
<td>email addresses</td>
<td>Enter the email addresses of the subscribers to whom the campaign has already been sent.</td>
</tr>
<tr >
<td>Delete associated bounce records</td>
<td>Whether the plugin should delete bounces for the campaign/subscribers. This allows you to resend to a bounced address
and also remove the bounces.</td>
</tr>
<tr >
<td>Adjust campaign totals</td>
<td>Whether to decrement the 'processed' and 'ashtml' or 'astext' totals for the campaign for each subscriber.</td>
</tr>
<tr >
<td>Requeue the campaign</td>
<td>Whether to resubmit the campaign.</td>
</tr>
</table>
