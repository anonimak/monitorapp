<template>
    <main class="container h-100">
        <div class="row justify-content-center align-items-center text-center">
            <div class="col-xl-6 col-lg-8 col-md-8">
                <slot />
            </div>
        </div>
    </main>
    <!-- <Footer /> -->
</template>
<script>
// import Footer from "@/components/Footer";

export default {
    components: {},
    methods: {
        handleLogout() {
            alert("Ini Sudah Logout");
        }
    }
};
</script>
<style scoped>
.bg-main {
    /* background-color: #009688; */
    background-image: linear-gradient(180deg, #009688 10%, #055048 100%);
    background-size: cover;
    height: 100%;
}

.bg-login-image {
    background: url(/img/svg/login.svg);
    width: 25px;
    height: 25px;
    background-position-x: 0%;
    background-position-y: 0%;
    background-size: 4rem;
    background-position: center;
    background-size: cover;
}
</style>
