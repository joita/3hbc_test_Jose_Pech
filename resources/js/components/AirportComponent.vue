<template>
    <v-app>
        <v-card class="mx-auto" max-width="400">
            <v-img
                class="white--text align-center"
                height="200px"
                src="https://cdn.gihub.org/umbraco/media/4914/smart-airports.png">
            </v-img>
            <v-card-title class="pb-0">
                    Airports
            </v-card-title>
            <v-card-actions>
                <v-btn color="black" text @click="openModal">
                    Ver Dashboard
                </v-btn>
            </v-card-actions>
        </v-card>
        <v-dialog
            v-model="dialogAirport"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
            persist
        >
      <v-card>
        <v-toolbar
          dark
          color="primary"
        >
          <v-toolbar-title>Airports</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn
              dark
              text
              @click="dialogAirport = false"
            >
              Cerrar
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-row>
            <v-col cols="12">
                <v-col cols="12">
                    <v-data-table
                        :headers="headers"
                        :items="desserts"
                        sort-by="calories"
                        class="elevation-1"
                    >
                        <template v-slot:top>
                        <v-toolbar
                            flat
                        >
                            <v-toolbar-title>Listado de Airports</v-toolbar-title>
                            <v-divider
                            class="mx-4"
                            inset
                            vertical
                            ></v-divider>
                            <v-spacer></v-spacer>
                            <v-dialog
                            v-model="dialogForm"
                            max-width="500px"
                            persistent
                            >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                color="green"
                                small
                                dark
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                                >
                                Agregar Airport
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                <span class="text-h5" v-show="itemId == null">Agregar Airport</span>
                                <span class="text-h5" v-show="itemId != null">Editar Airport</span>
                                </v-card-title>

                                <v-card-text>
                                <v-container>
                                    <v-row>
                                    <v-col
                                        cols="12"
                                        sm="12"
                                        md="12"
                                    >
                                        <v-text-field
                                        v-model="name"
                                        label="Name"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        sm="12"
                                        md="12"
                                    >
                                        <v-text-field
                                        v-model="code"
                                        label="Code"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        sm="12"
                                        md="12"
                                    >
                                        <v-text-field
                                        v-model="city"
                                        label="City"
                                        ></v-text-field>
                                    </v-col>
                                    </v-row>
                                </v-container>
                                </v-card-text>

                                <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="red"
                                    text
                                    @click="closeModalInsert"
                                >
                                    Cancelar
                                </v-btn>
                                <v-btn color="green" text
                                    @click="save"
                                    v-show="itemId == null"
                                >
                                    Guardar
                                </v-btn>
                                <v-btn color="green" text
                                    @click="update"
                                    v-show="itemId != null"
                                >
                                    Actualizar
                                </v-btn>
                                </v-card-actions>
                            </v-card>
                            </v-dialog>
                            <v-dialog v-model="dialogDelete" max-width="500px">
                            <v-card>
                                <v-card-title class="text-h5">
                                    Está seguro de eliminar el registro con # {{ itemId }}
                                </v-card-title>
                                <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn text @click="closeDelete" color="red">Cancelar</v-btn>
                                <v-btn text @click="deteleConfirm" color="green">Continuar</v-btn>
                                <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                            </v-dialog>
                        </v-toolbar>
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-btn x-small color="green"  @click="editItem(item)" dark>
                                Editar
                            </v-btn>

                            <v-btn x-small color="red"  @click="deleteItem(item)" dark>
                                Eliminar
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-col>
            </v-col>
        </v-row>
      </v-card>
        </v-dialog>
        <v-snackbar
                v-model="snackbar"
                top
                :color="colorSnack"
                :timeout="timeout"
            >
                {{ textSnack }}
        </v-snackbar>
    </v-app>
</template>

<script>
    import axios from "axios";
    export default {
        data () {
            return {
                timeout: 2000,
                dialogAirport: false,
                dialogDelete: false,
                dialogForm: false,
                headers: [
                    { text: 'ID', align: 'start', value: 'id',},
                    { text: 'NAME', value: 'name' },
                    { text: 'CODE', value: 'code' },
                    { text: 'CITY', value: 'city' },
                    { text: 'OPCIONES', value: 'actions', sortable: false },
                ],
                desserts: [],
                itemId: null,
                name: null,
                code: null,
                city: null,
                snackbar: false,
                colorSnack: null,
                textSnack: null,
                urlRoot: 'http://localhost:8000/'
            }
        },
        methods: {
            openModal(){
                vm.dialogAirport = true
            },
            closeModalInsert(){
                vm.dialogForm = false
                vm.name = null
                vm.code = null
                vm.city = null
                vm.itemId = null
            },
            openSnackbar(color,texto){
                vm.snackbar = true
                vm.colorSnack = color
                vm.textSnack = texto
            },
            save(){
                axios.post(vm.urlRoot+'create/airport', {
                    name: vm.name,
                    code: vm.code,
                    city: vm.city
                }).then(response => {
                    vm.openSnackbar('green','Airport registrado con éxito')
                    vm.list()
                    vm.closeModalInsert()
                }).catch(e => {
                    console.log(e);
                });
            },
            list(){
                axios.get(vm.urlRoot+'get/airport', {}).then(response => {
                    vm.desserts = response.data
                }).catch(e => {
                    console.log(e);
                });
            },
            editItem (item) {
                vm.itemId = item.id
                vm.name = item.name
                vm.code = item.code
                vm.city = item.city
                vm.dialogForm = true
            },
            update(){
                axios.post(vm.urlRoot+'update/airport', {
                    name: vm.name,
                    code: vm.code,
                    city: vm.city,
                    id: vm.itemId
                }).then(response => {
                    vm.openSnackbar('green','Airport actualizado con éxito')
                    vm.list()
                    vm.closeModalInsert()
                }).catch(e => {
                    console.log(e);
                });
            },
            deleteItem (item) {
                vm.itemId = item.id
                vm.dialogDelete = true
            },
            closeDelete(){
                vm.itemId = null
                vm.dialogDelete = false
            },
            deteleConfirm(){
                axios.post(vm.urlRoot+'delete/airport', {
                    id: vm.itemId
                }).then(response => {
                    vm.openSnackbar('green','Airport eliminado con éxito')
                    vm.list()
                    vm.closeDelete()
                }).catch(e => {
                    console.log(e);
                });
            }
        },
        mounted() {
            window.vm = this
            vm.list()
        }
    }
</script>
