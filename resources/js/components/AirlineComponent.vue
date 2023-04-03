<template>
    <v-app>
        <v-card class="mx-auto" max-width="400">
                    <v-img
                    class="black--text align-end"
                    height="200px"
                    src="https://cdn.pixabay.com/photo/2014/11/02/10/41/plane-513641_640.jpg"
                    >
                    </v-img>

                    <v-card-title class="pb-0">
                    Airlines
                    </v-card-title>
                    <v-card-actions>
                    <v-btn color="black" text  @click="openModalAirline">
                        ver Dashboard
                    </v-btn>
                    </v-card-actions>
        </v-card>
        <v-dialog
            v-model="dialogAirline"
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
          <v-toolbar-title>Airlines</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn
              dark
              text
              @click="dialogAirline = false"
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
                            <v-toolbar-title>Listado de Airlines</v-toolbar-title>
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
                                Agregar Airline
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                <span class="text-h5" v-show="itemId == null">Agregar Airline</span>
                                <span class="text-h5" v-show="itemId != null">Editar Airline</span>
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
                :timeout="timeoutAirline"
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
                timeoutAirline: 2000,
                dialogAirline: false,
                dialogDelete: false,
                dialogForm: false,
                headers: [
                    { text: 'ID', align: 'start', value: 'id',},
                    { text: 'NAME', value: 'name' },
                    { text: 'CODE', value: 'code' },
                    { text: 'OPCIONES', value: 'actions', sortable: false },
                ],
                desserts: [],
                itemId: null,
                name: null,
                code: null,
                snackbar: false,
                colorSnack: null,
                textSnack: null,
                urlRoot: 'http://localhost:8000/'
            }
        },
        methods: {
            openModalAirline(){
                vmAirline.dialogAirline = true
            },
            closeModalInsert(){
                vmAirline.dialogForm = false
                vmAirline.name = null
                vmAirline.code = null
                vmAirline.itemId = null
            },
            openSnackbar(color,texto){
                vmAirline.snackbar = true
                vmAirline.colorSnack = color
                vmAirline.textSnack = texto
            },
            save(){
                axios.post(vmAirline.urlRoot+'create/airline', {
                    name: vmAirline.name,
                    code: vmAirline.code
                }).then(response => {
                    vmAirline.openSnackbar('green','Airline registrado con éxito')
                    vmAirline.list()
                    vmAirline.closeModalInsert()
                }).catch(e => {
                    console.log(e);
                });
            },
            list(){
                axios.get(vmAirline.urlRoot+'get/airline', {}).then(response => {
                    vmAirline.desserts = response.data
                }).catch(e => {
                    console.log(e);
                });
            },
            editItem (item) {
                vmAirline.itemId = item.id
                vmAirline.name = item.name
                vmAirline.code = item.code
                vmAirline.city = item.city
                vmAirline.dialogForm = true
            },
            update(){
                axios.post(vmAirline.urlRoot+'update/airline', {
                    name: vmAirline.name,
                    code: vmAirline.code,
                    city: vmAirline.city,
                    id: vmAirline.itemId
                }).then(response => {
                    vmAirline.openSnackbar('green','Airline actualizado con éxito')
                    vmAirline.list()
                    vmAirline.closeModalInsert()
                }).catch(e => {
                    console.log(e);
                });
            },
            deleteItem (item) {
                vmAirline.itemId = item.id
                vmAirline.dialogDelete = true
            },
            closeDelete(){
                vmAirline.itemId = null
                vmAirline.dialogDelete = false
            },
            deteleConfirm(){
                axios.post(vmAirline.urlRoot+'delete/airline', {
                    id: vmAirline.itemId
                }).then(response => {
                    vmAirline.openSnackbar('green','Airline eliminado con éxito')
                    vmAirline.list()
                    vmAirline.closeDelete()
                }).catch(e => {
                    console.log(e);
                });
            }
        },
        mounted() {
            window.vmAirline = this
            vmAirline.list()
        }
    }
</script>