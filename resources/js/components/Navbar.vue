<template>
    <!-- Topbar -->
    <nav
        class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
    >
        <!-- Sidebar Toggle (Topbar) -->
        <button
            id="sidebarToggleTop"
            class="btn btn-link d-md-none rounded-circle mr-3"
        >
            <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="userDropdown"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{
                        userdata.name
                    }}</span>
                    <!-- <img
                        class="img-profile rounded-circle"
                        src="https://source.unsplash.com/QAB-WJcbgJk/60x60"
                    /> -->
                </a>
                <!-- Dropdown - User Information -->
                <div
                    class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown"
                >
                    <inertia-link
                        class="dropdown-item"
                        :href="route('admin.passwordreset')"
                    >
                        <i
                            class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"
                        ></i>
                        Change Password
                    </inertia-link>
                    <div class="dropdown-divider"></div>
                    <button class="dropdown-item" @click="show = true">
                        <i
                            class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                        ></i>
                        Logout
                    </button>
                </div>
            </li>
        </ul>

        <b-modal
            v-model="show"
            title="Logout"
            header-bg-variant="primary"
            header-text-variant="light"
        >
            Anda akan keluar
            <template v-slot:modal-footer>
                <b-button variant="secondary" @click="show = false">
                    batal
                </b-button>
                <b-link
                    class="btn btn-primary"
                    size="sm"
                    :href="route('logout')"
                >
                    Keluar
                </b-link>
            </template>
        </b-modal>
    </nav>
    <!-- End of Topbar -->
</template>
<script>
export default {
    props: ["userdata"],
    data() {
        return {
            show: false,
            alertstatus: null,
            messagestatus: null
        };
    }
};
</script>
