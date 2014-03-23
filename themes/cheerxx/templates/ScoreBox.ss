<!--<div class="panel">-->

	<h3>Scores</h3>
<% if Item.IsScored %>

	<% with Item %>
		<table class="scorebox">
			<tbody>
				<% loop SubmissionScores %>
					<tr>
						<td>$ScoreCategory.Title</td>
						<td class="score">$PartialScore</td>
					</tr>
				<% end_loop %>
				<tr class="special">
					<td>Like points</td>
					<td class="score">$LikeScore</td> <!-- calculate points from likes -->
				</tr>
			</tbody>
			<tfoot>
			    <tr>
			      <td>Total</td>
			      <td class="score">$TotalScore</td>
			    </tr>
			  </tfoot>
		</table>
		<p><a href="#" data-reveal-id="scoremodal" data-reveal class="button small radius">Edit scores</a></p>
		<p>
			<small>This video can gain up to $Target.ChallengeCategory.LikesWeight points for the first 100 likes. Share it!</small>
		</p>
		
	<% end_with %>
		
		
<% else %>
		<% if CanScore %>
			<p>
				You have not submitted a score yet. &nbsp; <a href="#" data-reveal-id="scoremodal" data-reveal class="button small radius">Submit a score</a>
			</p>
		<% else %>
			<p>
				The video has not been evaluated yet.
			</p>
		<% end_if %>
		
<% end_if %>
	
<!--</div>-->

<div id="scoremodal" class="reveal-modal small" data-reveal>
	$ScoringForm
</div>