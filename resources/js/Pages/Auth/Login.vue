<template>
    <Layout>
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">
                                    MONITORING APP
                                </h1>
                            </div>
                            <flash-msg />
                            <b-form @submit.prevent="onSubmit" v-if="show">
                                <b-form-group
                                    id="input-group-1"
                                    label-for="input-1"
                                    :invalid-feedback="
                                        $page.errors.email
                                            ? $page.errors.email[0]
                                            : ''
                                    "
                                    :state="$page.errors.email ? false : null"
                                >
                                    <b-form-input
                                        id="input-1"
                                        v-model="form.email"
                                        type="text"
                                        name="email"
                                        placeholder="Enter username"
                                        :state="
                                            $page.errors.email ? false : null
                                        "
                                    ></b-form-input>
                                </b-form-group>

                                <b-form-group
                                    id="input-group-2"
                                    label-for="input-2"
                                    :invalid-feedback="
                                        $page.errors.password
                                            ? $page.errors.password[0]
                                            : ''
                                    "
                                    :state="
                                        $page.errors.password ? false : null
                                    "
                                >
                                    <b-form-input
                                        id="input-2"
                                        type="password"
                                        name="password"
                                        v-model="form.password"
                                        placeholder="Password"
                                        :state="
                                            $page.errors.password ? false : null
                                        "
                                    ></b-form-input>
                                </b-form-group>
                                <b-form-group> </b-form-group>
                                <!-- <button @click.prevent="recaptcha">
                                    Execute recaptcha
                                </button> -->

                                <b-button
                                    class="btn-block"
                                    type="submit"
                                    variant="primary"
                                    >Submit</b-button
                                >
                            </b-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "@/Shared/LoginLayout"; //import layouts
import FlashMsg from "@/components/Alert";

export default {
    metaInfo: { title: "Beranda" },
    data() {
        return {
            form: {
                email: "",
                password: "",
                remember: "",
                token: ""
            },
            show: true
        };
    },
    computed: {
        state() {
            return this.form.email.length >= 4 ? true : false;
        }
    },
    components: {
        Layout,
        FlashMsg
    },
    props: ["meta"],
    methods: {
        onSubmit() {
            this.$recaptchaLoaded().then(() => {
                console.log("recaptcha loaded");
                this.$recaptcha("login").then(token => {
                    this.form.token = token;
                    this.$inertia.post("/login", this.form);
                });
            });
            // this.recaptcha().then(token => console.log(token));
        },
        onReset(e) {
            e.preventDefault();
        }
    }
};
</script>
