<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form class="form" id="add_edit_profile_skill" method="POST" action="{{ route('store.front.profile.skill', [$user->id]) }}">{{ csrf_field() }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{__('Add Skill')}}</h4>
            </div>
            @include(config('app.THEME_PATH').'.user.forms.skill.skill_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-large btn-primary" onClick="submitProfileSkillForm();">{{__('Add Skill')}} </button>
            </div>
        </form>
    </div>
    <!-- /.modal-content --> 
</div>
<!-- /.modal-dialog -->