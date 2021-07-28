<template>
    <layout :userinfo="userinfo">
        <flash-msg />
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Change New Password</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <b-card no-body>
                    <b-form @submit.prevent="submit">
                        <b-card-body>
                            <b-col col lg="3" md="auto">
                                <b-form-group
                                    id="input-group-title"
                                    label="Username:"
                                    label-for="input-title"
                                >
                                    <b-form-input
                                        id="email"
                                        type="email"
                                        v-model="form.email"
                                        readonly
                                        required
                                        autofocus
                                        autocomplete="username"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col col lg="3" md="auto">
                                <b-form-group
                                    id="input-group-title"
                                    label="Password:"
                                    label-for="input-title"
                                    :invalid-feedback="
                                        errors.password
                                            ? errors.password[0]
                                            : ''
                                    "
                                    :state="errors.password ? false : null"
                                >
                                    <b-form-input
                                        id="password"
                                        type="password"
                                        v-model="form.password"
                                        :state="errors.password ? false : null"
                                        required
                                        autocomplete="new-password"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col col lg="3" md="auto">
                                <b-form-group
                                    id="input-group-title"
                                    label="Confirm Password:"
                                    label-for="input-title"
                                    :invalid-feedback="
                                        errors.password_confirmation
                                            ? errors.password_confirmation[0]
                                            : ''
                                    "
                                    :state="
                                        errors.password_confirmation
                                            ? false
                                            : null
                                    "
                                >
                                    <b-form-input
                                        id="password_confirmation"
                                        type="password"
                                        v-model="form.password_confirmation"
                                        :state="
                                            errors.password_confirmation
                                                ? false
                                                : null
                                        "
                                        required
                                        autocomplete="new-password"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-row>
                                <b-col>
                                    <b-button-group>
                                        <b-button
                                            type="submit"
                                            variant="primary"
                                            >Submit</b-button
                                        >
                                    </b-button-group>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </b-form>
                </b-card>
            </div>
        </div>
    </layout>
</template>
<script>
import Layout from "@/Shared/AdminLayout"; //import layouts
import FlashMsg from "@/components/Alert";

export default {
    components: {
        Layout,
        FlashMsg
    },

    props: {
        email: String,
        _token: String,
        userinfo: Object,
        errors: Object
    },

    data() {
        return {
            form: {
                token: this.token,
                email: this.email,
                password: "",
                password_confirmation: ""
            }
        };
    },

    methods: {
        submit() {
            this.$inertia.post(this.route("admin.passwordupdate"), this.form, {
                onFinish: () =>
                    this.form.reset("password", "password_confirmation")
            });
        }
    }
};
</script>
