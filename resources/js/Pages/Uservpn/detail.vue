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
                                            <inertia-link
                                                :href="route(__back)"
                                                class="btn btn-secondary my-2 float-right"
                                            >
                                                <i
                                                    class="fas fa-caret-left"
                                                ></i>
                                                Back</inertia-link
                                            >
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
                                                <th scope="col">Client IP</th>
                                                <th scope="col">Domain Name</th>
                                                <th scope="col">
                                                    Type
                                                </th>
                                                <th scope="col">Timestamp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(item,
                                                index) in dataClientDns.data"
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
                                                    {{ item.client_ip }}
                                                </td>
                                                <td>
                                                    {{ item.domain_name }}
                                                </td>
                                                <td>
                                                    <span
                                                        v-if="
                                                            item.type == 2 ||
                                                                item.type == 3
                                                        "
                                                        class="badge badge-success"
                                                        >allowed</span
                                                    >
                                                    <span
                                                        v-else
                                                        class="badge badge-danger"
                                                        >blocked</span
                                                    >
                                                </td>
                                                <td>
                                                    {{
                                                        item.timestamp
                                                            | moment(
                                                                "dddd, MMMM Do YYYY, h:mm:ss a"
                                                            )
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <Pagination :links="dataClientDns.links" />
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
        "dataClient",
        "dataClientDns",
        "userinfo",
        "filters",
        "perPage",
        "__export",
        "__index",
        "__back"
    ],
    metaInfo: { title: `Detail User VPN` },
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
            Inertia.reload({ only: ["dataClientDns"] });
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
        actionExport() {
            let query = pickBy(this.form);

            query = Object.keys(query).length ? query : { remember: "forget" };
            query = {
                ...query,
                ...{
                    ip: this.dataClient.virt_address.split(".").join("_")
                }
            };
            location.href = this.route(this.__export, query);
        },
        refreshData() {
            Inertia.reload({ only: ["dataClientDns"] });
        },
        reset() {
            this.form = mapValues(this.form, () => null);
        }
    },
    watch: {
        form: {
            handler: throttle(function() {
                let query = pickBy(this.form);

                query = Object.keys(query).length
                    ? query
                    : { remember: "forget" };
                query = {
                    ...query,
                    ...{
                        ip: this.dataClient.virt_address.split(".").join("_")
                    }
                };
                this.$inertia.replace(this.route(this.__index, query));
            }, 150),
            deep: true
        }
    }
};
</script>
