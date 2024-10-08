<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    flights:{
        type: Array,
    },
    appUrl:{
        type: String,
    },
});


</script>

<template>
    <div class="container">
        <h1>Skybound Airlines</h1>
        <h2 class="title">Manage Tickets</h2>
      
        <div class="form-container">
            <form @submit.prevent="createTicket" class="ticket-form">
            <h2>Book Flight</h2>
            <div class="form-group">
                <label for="flight">Flight:</label>
                <select id="flight-info" v-model="newTicket.flight_id" required>
                    <option value="" disabled>Please select flight</option>
                    <option v-for="flight in flights" :key="String(flight.id)" :value="String(flight.id)">
                    {{ flight.flight_name }} {{ flight.source_airport }} - {{ flight.destination_airport }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="passanger">Your Full Name:</label>
                <input type="text" id="fullname" v-model="newTicket.passenger_name" required>
            </div>
            <div class="form-group">
                <label for="passport">Your Passport Number:</label>
                <input type="text" id="passport" v-model="newTicket.passport" required>
            </div>
            
            <button type="submit" class="btn">Book Now</button>
            </form>
    
            <form @submit.prevent="cancelTicket" class="ticket-form">
            <h2>Cancel and Get a Refund</h2>
            <div class="form-group">
                <label for="ticketId">Ticket ID:</label>
                <input type="number" id="ticketId" v-model="cancelTicketId" required>
            </div>
            <button type="submit" class="btn">Refund a Ticket</button>
            </form>

            <form @submit.prevent="updateSeat" class="ticket-form">
            <h2>Update seat</h2>
            <div class="form-group">
                <label for="ticketId">Ticket ID:</label>
                <input type="number" id="ticketId" v-model="seatTicketId" required>
            </div>
            <div class="form-group">
                <label for="seatSelect">Select Seat:</label>
                <select v-model="selectedSeatNumber" class="seat-select" id="seatSelect">
                    <option value="" disabled>Select row number</option>
                    <option v-for="n in 32" :key="n" :value="n">{{ n }}</option>
                </select>
                <select v-model="selectedSeat" class="seat-select">
                <option value="" disabled>Select seat</option>
                <option v-for="seat in ['A', 'B', 'C', 'D']" :key="seat" :value="seat">{{ seat }}</option>
                </select>
            </div>
            <button type="submit" class="btn">Update Seat</button>
            </form>
        </div>
        <div class="get-tickets-container">
            <button @click="getTickets" class="btn get-tickets-btn">Get Tickets Data</button>
            <button @click="resetDefaultData" class="btn get-tickets-btn reset-btn">Reset Data to Demo Defaults</button>
            <textarea v-model="ticketsData" class="tickets-data" readonly></textarea>
        </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        newTicket: {
          flight_id: '',
          passenger_name: '',
          passport: ''
        },
        ticketsData:'',
        cancelTicketId: null,
        seatTicketId: null,
        selectedSeatNumber: 1,
        selectedSeat: "A",
      }
    },
    methods: {
        async createTicket() {
            try {
                const response = await axios.post(this.appUrl+'/api/tickets', this.newTicket);
                console.log('Ticket created:', response.data);
                // Reset form after successful submission
                this.newTicket = { flight: '', seat: '' };
                // Optionally, you can update the tickets data or show a success message
                this.getTickets(); // Refresh the tickets list
            } catch (error) {
                console.error('Error creating ticket:', error);
                // Handle the error (e.g., show an error message to the user)
            }
        },
      async cancelTicket() {
        // Implement ticket cancellation logic here
        const response = await axios.delete(this.appUrl+'/api/tickets/' + this.cancelTicketId);
        // Reset form after submission
        this.cancelTicketId = null;
        this.getTickets();
      },
      async getTickets() {
        try {
            const response = await axios.get(this.appUrl+'/api/tickets');
            this.ticketsData = JSON.stringify(response.data, null, 2);
        } catch (error) {
            console.error('Error fetching tickets:', error);
            this.ticketsData = 'Error fetching tickets. Please try again.';
        }
      },
      async updateSeat() {
        try {
            const newSeat = this.selectedSeatNumber + this.selectedSeat;
            const response = await axios.put(this.appUrl+`/api/tickets/${this.seatTicketId}/seat`,{'seat':newSeat});
            this.ticketsData = JSON.stringify(response.data, null, 2);
        } catch (error) {
            console.error('Error:', error);
            this.ticketsData = ('Error:', error);
        }
      },
        async resetDefaultData() {
            if (confirm('Are you sure you want to reset Tickets data?')) {
                const response = await axios.post(this.appUrl+`/api/tickets/reset`);
                this.ticketsData = JSON.stringify(response.data, null, 2);
            }
        },
    }
  }
  </script>
  
  <style scoped>
  .container {
    max-width: 100%;
    margin: 0 auto;
    padding: 20px;
    display:flex;
    flex-wrap: wrap;
  }
  
  .title {
    font-size: 2.5em;
    font-weight: bold;
    text-align: center;
    margin-bottom: 30px;
    width:100%;
  }
  
  .form-container {
    display: flex;
    flex-wrap: wrap;
    width:50%;
}

.ticket-form {
    width: 47%;
    min-width:360px;
    margin: 0.5ch;
    border: 1px solid lightgray;
    padding: 2ch;
    border-radius: 2px;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  label {
    display: block;
    margin-bottom: 5px;
  }
  
  input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  .radio-dot{
    width:auto;
  }
  
  .btn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .btn:hover {
    background-color: #45a049;
  }

    .get-tickets-container {
    margin-top: 2ch;
    width:50%;

    }

    .get-tickets-btn {
        margin-right: 2ch;
    margin-bottom: 15px;
    color:black;
    background-color: lightgray;
    border: 1px solid transparent;
    }

    .reset-btn {
        
        background-color: whitesmoke;
        color:red;
        border:1px solid red;
    }

    .get-tickets-btn:hover {
        background-color: black;
        color:whitesmoke;
        border: 1px solid transparent;
    }

    .tickets-data {
    width: 100%;
    min-height: 300px;
    height: 90%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    resize: vertical;
    }

    .seat-select{
        width:8ch;
        margin-right: 1ch;
    }

    @media screen and (max-width: 768px) {
    .form-container {
        width: 100%;
        max-width: 100%;
    }
    .ticket-form {
        width:100%;
    }
    .get-tickets-container{
        width:100%;
    }
    }

  </style>
