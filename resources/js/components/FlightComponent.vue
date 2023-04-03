<template>
    <v-app>
        <v-card
                class="mx-auto"
                max-width="400"
            >
                <v-img
                class="black--text align-end"
                height="200px"
                src="https://www.omanair.com/storage/pages/1200_627/1200x627flight-schedule.jpg"
                >
                </v-img>

                <v-card-title class="pb-0">
                Flights 
                </v-card-title>

                <v-card-actions>
                <v-btn color="dark" text @click="openModal">
                    Ver Dashboard
                </v-btn>
                </v-card-actions>
            </v-card>
            <v-dialog
            v-model="dialogFlight"
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
          <v-toolbar-title>Flights</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn
              dark
              text
              @click="dialogFlight = false"
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
                            <v-toolbar-title>Listado de Flights</v-toolbar-title>
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
                                Agregar Flight
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                <span class="text-h5" v-show="itemId == null">Agregar Flight</span>
                                <span class="text-h5" v-show="itemId != null">Editar Flight</span>
                                </v-card-title>

                                <v-card-text>
                                <v-container>
                                    <v-row>
                                    <v-col cols="12" sm="12" md="6">
                                        <v-text-field
                                        v-model="code"
                                        label="Code"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col  cols="12" sm="12" md="6">
                                    <v-autocomplete
                                        v-model="type"
                                        :items="types"
                                        label="Type"
                                        item-value="tipo"
                                        item-text="tipo">
                                    </v-autocomplete>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12">
                                    <v-autocomplete
                                        v-model="departure_id"
                                        :items="airports"
                                        label="Departure"
                                        item-value="id"
                                        item-text="name">
                                    </v-autocomplete>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12">
                                    <v-autocomplete
                                        v-model="destination_id"
                                        :items="airports"
                                        label="Destination"
                                        item-value="id"
                                        item-text="name">
                                    </v-autocomplete>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="6">
                                        <v-menu
                                            ref="menu"
                                            v-model="menu2"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            :return-value.sync="time"
                                            transition="scale-transition"
                                            offset-y
                                            max-width="290px"
                                            min-width="290px"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="departure_time"
                                                label="Departure Time"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                            ></v-text-field>
                                            </template>
                                            <v-time-picker
                                            v-if="menu2"
                                            v-model="departure_time"
                                            full-width
                                            @click:minute="$refs.menu.save(departure_time)"
                                            ></v-time-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="6">
                                        <v-menu
                                            ref="menuArrival"
                                            v-model="menu"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            :return-value.sync="arrival_time"
                                            transition="scale-transition"
                                            offset-y
                                            max-width="290px"
                                            min-width="290px"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="arrival_time"
                                                label="Arrival Time"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                            ></v-text-field>
                                            </template>
                                            <v-time-picker
                                            v-if="menu"
                                            v-model="arrival_time"
                                            full-width
                                            @click:minute="$refs.menuArrival.save(arrival_time)"
                                            ></v-time-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12">
                                    <v-autocomplete
                                        v-model="airline_id"
                                        :items="airlines"
                                        label="Airline"
                                        item-value="id"
                                        item-text="name">
                                    </v-autocomplete>
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
                dialogFlight: false,
                dialogDelete: false,
                dialogForm: false,
                headers: [
                    { text: 'ID', align: 'start', value: 'id',},
                    { text: 'CODE', value: 'code' },
                    { text: 'TYPE', value: 'type' },
                    { text: 'DEPARTURE', value: 'name_departure' },
                    { text: 'DESTINATION', value: 'name_destino' },
                    { text: 'DEPARTURE TIME', value: 'departure_time' },
                    { text: 'ARRIVAL TIME', value: 'arrival_time' },
                    { text: 'AIRLINE', value: 'airline_name' },
                    { text: 'OPCIONES', value: 'actions', sortable: false },
                ],
                desserts: [],
                itemId: null,
                code: null,
                types: [{"tipo": "PASSENGER"},{"tipo": "FREIGHT"}],
                type: null,
                departure_id: null,
                destination_id: null,
                departure_time: null,
                arrival_time: null,
                airline_id: null,
                snackbar: false,
                colorSnack: null,
                textSnack: null,
                airports: [],
                airlines: [],
                menu2: false,
                menu: false,
                urlRoot: 'http://localhost:8000/'
            }
        },
        methods: {
            openModal(){
                vmFligth.dialogFlight = true
            },
            closeModalInsert(){
                vmFligth.dialogForm = false
                vmFligth.code = null
                vmFligth.type = null
                vmFligth.departure_id = null,
                vmFligth.destination_id = null,
                vmFligth.departure_time = null,
                vmFligth.arrival_time = null,
                vmFligth.airline_id = null,
                vmFligth.itemId = null
            },
            openSnackbar(color,texto){
                vmFligth.snackbar = true
                vmFligth.colorSnack = color
                vmFligth.textSnack = texto
            },
            save(){
                axios.post(vmFligth.urlRoot+'create/flight', {
                    code: vmFligth.code,
                    type: vmFligth.type,
                    departure_id: vmFligth.departure_id ,
                    destination_id: vmFligth.destination_id,
                    departure_time: vmFligth.departure_time,
                    arrival_time: vmFligth.arrival_time,
                    airline_id: vmFligth.airline_id
                }).then(response => {
                    vmFligth.openSnackbar('green','Flight registrado con éxito')
                    vmFligth.list()
                    vmFligth.closeModalInsert()
                }).catch(e => {
                    console.log(e);
                });
            },
            list(){
                axios.get(vmFligth.urlRoot+'get/flight', {}).then(response => {
                    vmFligth.desserts = response.data
                }).catch(e => {
                    console.log(e);
                });
            },
            listAirport(){
                axios.get(vmFligth.urlRoot+'get/airport', {}).then(response => {
                    vmFligth.airports= response.data
                }).catch(e => {
                    console.log(e);
                });
            },
            listAirline(){
                axios.get(vmFligth.urlRoot+'get/airline', {}).then(response => {
                    vmFligth.airlines = response.data
                }).catch(e => {
                    console.log(e);
                });
            },
            editItem (item) {
                vmFligth.itemId = item.id
                vmFligth.code = item.code
                vmFligth.type = item.type
                vmFligth.departure_id = item.departure_id,
                vmFligth.destination_id = item.destination_id,
                vmFligth.departure_time = item.departure_time,
                vmFligth.arrival_time = item.arrival_time,
                vmFligth.airline_id = item.airline_id,
                vmFligth.dialogForm = true
            },
            update(){
                axios.post(vmFligth.urlRoot+'update/flight', {
                    code: vmFligth.code,
                    type: vmFligth.type,
                    departure_id: vmFligth.departure_id ,
                    destination_id: vmFligth.destination_id,
                    departure_time: vmFligth.departure_time,
                    arrival_time: vmFligth.arrival_time,
                    airline_id: vmFligth.airline_id,
                    id: vmFligth.itemId
                }).then(response => {
                    vmFligth.openSnackbar('green','Flight actualizado con éxito')
                    vmFligth.list()
                    vmFligth.closeModalInsert()
                }).catch(e => {
                    console.log(e);
                });
            },
            deleteItem (item) {
                vmFligth.itemId = item.id
                vmFligth.dialogDelete = true
            },
            closeDelete(){
                vmFligth.itemId = null
                vmFligth.dialogDelete = false
            },
            deteleConfirm(){
                axios.post(vmFligth.urlRoot+'delete/flight', {
                    id: vmFligth.itemId
                }).then(response => {
                    vmFligth.openSnackbar('green','Fligth eliminado con éxito')
                    vmFligth.list()
                    vmFligth.closeDelete()
                }).catch(e => {
                    console.log(e);
                });
            }
        },
        mounted() {
            window.vmFligth = this
            vmFligth.list()
            vmFligth.listAirline()
            vmFligth.listAirport()
        }
    }
</script>