<!-- TITLE -->
<div class="row">
	<div class="col-xs-4 col-sm-4">
		<h1 class="page-title txt-color-blueDark"><i class="icon-fab-jog fab-fw"></i> Jog</h1>
	</div>
	<div class="col-xs-8 col-sm-8 text-right">
		<a id="reset-controller" class="btn btn-info " href="javascript:void(0)"  title="Reset Controller">Reset controller</a>
	</div>
</div>

<div class="row">
               <div class="col-sm-6">
                        <h5 class="text-left">You can connect to tcp://192.168.10.120:8080 using VLC to see the microscope video feed </h5>
                </div>
</div>


<!-- JOG -->
<div class="row">
	<div class="col-sm-12">
		<div class="well">
			<div class="row">
				<! -- buttons -->
				<div class="col-sm-3"></div>
				<div class="col-sm-9 ">
					<ul class="list-button pull-right">
						<li>
							<a id="act-joy" href="javascript:void(0);" class="btn btn-info btn-xs" title="Activate Joystick Control">Activate joystick</a>
						</li>
						<li>
							<a class="btn btn-info btn-xs" id="home-all-axis" data-macro="true"  href="javascript:void(0)"  title="Home all axis">Home All axis</a>
						</li>
						<li>
							<a class="btn btn-info btn-xs" id="zero-all" href="javascript:void(0)"  title="Zero All">Zero All</a>
						</li>
						<li>
							<a class="btn btn-info btn-xs" id="position" href="javascript:void(0)"  title="Position">Position</a>
						</li>
						<li>
							<a class="btn btn-info btn-xs" id="bed-align" data-macro="true" href="javascript:void(0)" class="macro" title="Auto Bed Leveling">ABL</a>
						</li>

						<li>
							<a id="gcode-manual" data-toggle="modal" href="<?php echo site_url("jog/manual") ?>" data-target="#manula-modal" class="btn btn-default btn-xs " href="javascript:void(0);"><i class="fa fa-support"></i> Help</a>
						</li>

					</ul>
				</div>
			</div>
			<div class="row">
				<!-- STEP, FEEDRATE -->
				<div class="col-sm-3">
					<div class="form-horizontal">
						<fieldset>
							<div class="form-group">
								<div class="col-md-5 control-label">
									<strong>ZY Step (mm)</strong>
								</div>
								<div class="col-md-7">
									<input  type="text" id="step" value="10">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-5 control-label">
									<strong>Feedrate</strong>
								</div>
								<div class="col-md-7">
									<input type="text" id="feedrate" value="1000">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-5 control-label">
									<strong>Z Step (mm)</strong>
								</div>
								<div class="col-md-7">
									<input  type="text" id="z-step" value="5">
								</div>
							</div>
						</fieldset>
					</div>
				</div>

				<!-- JOG DIRECTIONS -->
				<div class="col-sm-6 text-center">
					<div class="btn-group-vertical">
						<a href="javascript:void(0)" data-attribue-direction="up-left" data-attribute-keyboard="103" class="btn btn-default btn-lg directions btn-circle btn-xl rotondo"> <i class="fa fa-arrow-left fa-1x fa-rotate-45"> </i> </a>
						<a href="javascript:void(0)" data-attribue-direction="left" data-attribute-keyboard="100" class="btn btn-default btn-lg directions btn-circle btn-xl rotondo"> <span class="glyphicon glyphicon-arrow-left "> </span> </a>
						<a href="javascript:void(0)" data-attribue-direction="down-left" data-attribute-keyboard="97" class="btn btn-default btn-lg directions btn-circle btn-xl rotondo"> <i class="fa fa-arrow-down fa-rotate-45 "> </i> </a>
					</div>
					<div class="btn-group-vertical">
						<a href="javascript:void(0)" data-attribue-direction="up" data-attribute-keyboard="104" class="btn btn-default btn-lg directions btn-circle btn-xl rotondo"> <i class="fa fa-arrow-up fa-1x"> </i> </a>
						<a href="javascript:void(0)" data-attribue-direction="home" data-attribute-keyboard="101" class="btn btn-default btn-lg btn-circle btn-xl directions rotondo"> <i class="fa fa-bullseye"> </i> </a>
						<a href="javascript:void(0)" data-attribue-direction="down" data-attribute-keyboard="98" class="btn btn-default btn-lg directions btn-circle btn-xl rotondo"> <i class="glyphicon glyphicon-arrow-down "> </i> </a>
					</div>
					<div class="btn-group-vertical">
						<a href="javascript:void(0)" data-attribue-direction="up-right" data-attribute-keyboard="105" class="btn btn-default btn-lg directions btn-circle btn-xl rotondo"> <i class="fa fa-arrow-up fa-1x fa-rotate-45"> </i> </a>
						<a href="javascript:void(0)" data-attribue-direction="right" data-attribute-keyboard="102" class="btn btn-default btn-lg directions btn-circle btn-xl rotondo"> <span class="glyphicon glyphicon-arrow-right"> </span> </a>
						<a href="javascript:void(0)" data-attribue-direction="down-right" data-attribute-keyboard="99" class="btn btn-default btn-lg directions btn-circle btn-xl rotondo"> <i class="fa fa-arrow-right fa-rotate-45"> </i> </a>
					</div>
					<div class="btn-group-vertical" style="margin-left: 10px;">
						<a href="javascript:void(0)" class="btn btn-default axisz" data-attribute-step="1" data-attribute-function="zdown"> <i class="fa fa-angle-double-up"> </i>&nbsp;Z </a>
						<hr />
						<a href="javascript:void(0)" class="btn btn-default axisz" data-attribute-step="1" data-attribute-function="zup"> <i class="fa fa-angle-double-down"> </i>&nbsp; Z </a>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<!-- HELP MODAL -->
<div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="manula-modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content"></div>
	</div>
</div>
