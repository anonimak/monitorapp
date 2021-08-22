<template>
    <Layout :userinfo="userinfo">
        <flash-msg />
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User VPN</h1>
        </div>
        <breadcrumb :items="breadcrumbItems" />
        <div class="row">
            <div class="col-12">
                <div>
                    <b-card>
                        <keep-alive>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <a
                                                @click.prevent="actionExport"
                                                class="btn btn-primary my-2"
                                            >
                                                <i
                                                    class="fas fa-file-export"
                                                ></i>
                                                Export Data</a
                                            >
                                            <button
                                                type="button"
                                                title="refresh data"
                                                class="btn btn-secondary"
                                                @click="refreshData"
                                            >
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xs-12 mt-3">
                                        <search
                                            v-model="form.search"
                                            @reset="reset"
                                        />
                                    </div>
                                    <!-- table news -->
                                    <table class="table mt-4">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Id VPN</th>
                                                <th scope="col">
                                                    Online Status
                                                </th>
                                                <th scope="col">
                                                    Sistem Operasi
                                                </th>
                                                <th scope="col">
                                                    IP Lokal
                                                </th>
                                                <th scope="col">
                                                    IP Publik
                                                </th>
                                                <th scope="col">Mac Address</th>
                                                <th scope="col">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(item,
                                                index) in dataClients.data"
                                                :key="item.id"
                                            >
                                                <th scope="row">
                                                    {{
                                                        (filters.page !==
                                                        undefined
                                                            ? filters.page - 1
                                                            : 1 - 1) *
                                                            perPage +
                                                            index +
                                                            1
                                                    }}
                                                </th>
                                                <td>
                                                    {{ item.id_user }}
                                                </td>
                                                <td>
                                                    <span
                                                        v-if="
                                                            item.online_status ==
                                                                1
                                                        "
                                                        class="badge badge-success"
                                                        >online</span
                                                    >
                                                    <span
                                                        v-else
                                                        class="badge badge-danger"
                                                        >offline</span
                                                    >
                                                </td>
                                                <td>
                                                    {{ item.sistem_operasi }}
                                                </td>
                                                <td>
                                                    {{ item.ip_lokal }}
                                                </td>
                                                <td>
                                                    {{ item.ip_publik }}
                                                </td>
                                                <td>
                                                    {{ item.mac_addr }}
                                                </td>
                                                <td>
                                                    <b-button-group size="sm">
                                                        <inertia-link
                                                            class="btn btn-primary"
                                                            title="detail"
                                                            :href="
                                                                route(
                                                                    __detail,
                                                                    item.ip_lokal
                                                                        .split(
                                                                            '.'
                                                                        )
                                                                        .join(
                                                                            '_'
                                                                        )
                                                                )
                                                            "
                                                            >Detail</inertia-link
                                                        >
                                                    </b-button-group>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <Pagination :links="dataClients.links" />
                                </div>
                            </div>
                        </keep-alive>
                    </b-card>
                </div>
            </div>
        </div>
    </Layout>
</template>
<script>
import { Inertia } from "@inertiajs/inertia";
import Layout from "@/Shared/AdminLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import Pagination from "@/components/Pagination";
import Search from "@/components/Search";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

export default {
    props: [
        "meta",
        "flash",
        "breadcrumbItems",
        "dataClients",
        "userinfo",
        "filters",
        "perPage",
        "__detail",
        "__index",
        "__export"
    ],
    metaInfo: { title: "User VPN" },
    data() {
        return {
            tabIndexCfgHome: 0,
            form: {
                search: this.filters.search
            },
            intval: null,
            isCheched: false
        };
    },
    mounted() {
        this.intval = setInterval(() => {
            Inertia.reload({ only: ["dataClients"] });
        }, 60000);
    },
    destroyed() {
        clearInterval(this.intval);
    },
    components: {
        Layout,
        FlashMsg,
        Breadcrumb,
        Pagination,
        Search
    },
    methods: {
        refreshData() {
            Inertia.reload({ only: ["dataClients"] });
        },
        actionExport() {
            let query = pickBy(this.form);

            location.href = this.route(
                this.__export,
                Object.keys(query).length ? query : { remember: "forget" }
            );
        },
        reset() {
            this.form = mapValues(this.form, () => null);
        }
    },
    watch: {
        form: {
            handler: throttle(function() {
                let query = pickBy(this.form);
                this.$inertia.replace(
                    this.route(
                        this.__index,
                        Object.keys(query).length
                            ? query
                            : { remember: "forget" }
                    )
                );
            }, 150),
            deep: true
        }
    }
};
</script>
