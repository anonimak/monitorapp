<template>
    <Layout :userinfo="userinfo">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Content Row -->
            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div
                                        class="h4 font-weight-bold text-primary text-uppercase mb-1"
                                    >
                                        Jumlah User
                                    </div>
                                    <div
                                        class="h5 font-weight-bold text-gray-800"
                                    >
                                        {{ userTotal }}
                                        <span v-if="userOnline > 0">
                                            |
                                            <b-badge class="badge badge-success"
                                                >Online
                                                {{ userOnline }}</b-badge
                                            >
                                        </span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i
                                        class="fas fa-users fa-2x text-gray-300"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                        >
                            <h6 class="m-0 font-weight-bold text-primary">
                                Top User Agent
                            </h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Agent</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(item, index) in topUserAgent"
                                        :key="index"
                                    >
                                        <td scope="row">{{ index + 1 }}</td>
                                        <td>{{ item.sistem_operasi }}</td>
                                        <td>{{ item.total_sistem_operasi }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                        >
                            <h6 class="m-0 font-weight-bold text-primary">
                                Top Domain
                                <span class="text-success">Allowed</span>
                            </h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Domain Name</th>
                                        <th>Total Allowed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(item,
                                        index) in topDomainAllowed"
                                        :key="index"
                                    >
                                        <td scope="row">{{ index + 1 }}</td>
                                        <td>{{ item.domain_name }}</td>
                                        <td>{{ item.total_domain }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                        >
                            <h6 class="m-0 font-weight-bold text-primary">
                                Top Domain
                                <span class="text-danger">Blocked</span>
                            </h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Domain Name</th>
                                        <th>Total Blocked</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(item,
                                        index) in topDomainBlocked"
                                        :key="index"
                                    >
                                        <td scope="row">{{ index + 1 }}</td>
                                        <td>{{ item.domain_name }}</td>
                                        <td>{{ item.total_domain }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </Layout>
</template>

<script>
import Layout from "@/Shared/AdminLayout"; //import layouts

export default {
    metaInfo: { title: "Beranda" },
    data() {
        return {};
    },
    components: {
        Layout
    },
    props: [
        "meta",
        "userinfo",
        "userOnline",
        "userTotal",
        "topUserAgent",
        "topDomainBlocked",
        "topDomainAllowed"
    ],
    methods: {
        test: function() {
            alert("oke");
        }
    }
};
</script>
