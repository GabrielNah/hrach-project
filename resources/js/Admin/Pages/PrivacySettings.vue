<template>
    <div class="container bootstrap snippets bootdeys">
        <div class="row">
            <div class="col-xs-12 col-sm-9">
                <form class="form-horizontal" @submit.prevent="handleSubmit">
                    <div class="panel panel-default mb-3">
                        <div class="panel-body d-flex w-50 " style="height: 200px">
                            <img src="https://bootdey.com/img/Content/avatar/avatar6.png" class="img-circle profile-avatar" alt="User avatar">

                            <div class="d-flex flex-column h-100 justify-content-evenly align-items-start">
                                <span class="text-white">Name : {{  admin.value.name  }}</span>
                                <span class="text-white">Email : {{ admin.value.email }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title text-white">Admins info</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label text-white text-left" >Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                           name="name"
                                           placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label text-white text-left">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                           name="email"
                                           placeholder="Email">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default ">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label text-white">Current password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control"
                                           name="current_password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label text-white">New password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control"
                                           name="new_password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label text-white" style="white-space: nowrap">New password confirmation</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control"
                                           name="new_password_confirmation">
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, inject} from "vue";
import HTTP from "../Axios/axiosCongif";
import {errorNotification, successNotification} from "../../Services/NotificationService";
import {extractValidationErrors} from "../../Services/GlobalHelpers";

export default {
    name: "PrivacySettings",
    setup(){

        const store=inject('store')
        const admin=computed(()=>store.getters.admin)

        const setAdmin=(admin)=>{
            store.actions.setAdmin(admin)
        }

        const handleSubmit=(e)=>{
            const form=e.target;
            const data=new FormData(form)
            HTTP.post('/change',data)
            .then(({data})=>{
                if (data.success){
                    setAdmin(data.admin);
                    form.reset();
                    successNotification('Admin`s data modified successfully');
                }
            }).catch(e=>errorNotification(extractValidationErrors(e)))
        }

        return { admin,handleSubmit }
    }
}
</script>

<style scoped>

.panel {
    box-shadow: none;
}
.panel-heading {
    border-bottom: 0;
}
.panel-title {
    font-size: 17px;
}
.panel-title > small {
    font-size: .75em;
    color: #999999;
}
.panel-body *:first-child {
    margin-top: 0;
}
.panel-footer {
    border-top: 0;
}

.panel-default > .panel-heading {
    color: #333333;
    background-color: transparent;
    border-color: rgba(0, 0, 0, 0.07);
}

form label {
    color: #999999;
    font-weight: 400;
}


@media (min-width: 768px) {
    .form-horizontal .control-label {
        margin-bottom: 0;
        padding-top: 7px;
    }
}

.profile__contact-info-icon {
    float: left;
    font-size: 18px;
    color: #999999;
}
.profile__contact-info-body {
    overflow: hidden;
    padding-left: 20px;
    color: #999999;
}
.profile-avatar {
    width: 200px;
    position: relative;
    margin: 196px auto 0px;
    border: 4px solid #f3f3f3;
}
</style>
