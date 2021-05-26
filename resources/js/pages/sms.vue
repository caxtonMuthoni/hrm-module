<template>
  <div class="container-fluid">
    <div class="card">
      <div class="card-header"><strong>All Sent SMSes</strong></div>
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <th>SL No</th>
            <th>Avatar</th>
            <th>Employee</th>
            <th>Phone number</th>
            <th>Message</th>
            <th>Sent At</th>
            <th>DELETE</th>
          </thead>
          <tbody>
            <tr v-for="(sms, index) in smses" :key="sms.id">
              <td>{{ index + 1 }}</td>
              <td>
                <img
                  :src="sms.employee.user.photo"
                  alt="Photo"
                  class="avatar"
                />
              </td>
              <td>{{ sms.employee.user.name | capitalizeFirstLetter }}</td>
              <td>{{ sms.employee.phonenumber }}</td>
              <td>{{ sms.message }}</td>
              <td>
                {{ sms.created_at | fromNow | capitalizeFirstLetter }} ago
              </td>
              <td>
                <span>
                  <a
                    href=""
                    @click.prevent="deleteSms(sms.id)"
                    class="btn btn-danger"
                    ><i class="fas fa-trash"></i
                  ></a>
                </span>
              </td>
            </tr>
          </tbody>
          <tfoot>
            <th>SL No</th>
            <th>Avatar</th>
            <th>Employee</th>
            <th>Phone number</th>
            <th>Message</th>
            <th>Sent At</th>
            <th>DELETE</th>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {};
  },

  computed: {
    ...mapGetters({
      smses: "getSmses",
    }),
  },

  mounted() {
    this.getAllSMSes();
  },

  methods: {
    ...mapActions({
      getAllSMSes: "getSmsesAction",
      destroySMS: "deleteSMSAction",
    }),

    deleteSms(id) {
      this.$swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.destroySMS(id);
          }
        });
    },
  },
};
</script>
