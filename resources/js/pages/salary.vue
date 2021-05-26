<template>
  <div class="container-fluid py-3">
    <div class="card">
      <div class="card-header">
        <strong>Employees Salary</strong>
        <a
          @click.prevent="showModal(false)"
          href=""
          class="btn btn-success float-right"
        >
          <i class="fas mr-2 fa-plus"></i> Add Employee Salary</a
        >
      </div>
      <table class="table table-striped">
        <thead>
          <th>SL No</th>
          <th>Photo</th>
          <th>Employee Name</th>
          <th>Total Salary</th>
          <th>Action (EDIT / DELETE)</th>
        </thead>
        <tbody>
          <tr v-for=" (salary,index) in salaries" :key="salary.id">
            <td>{{ index + 1 }}</td>
            <td>
                <img
                  :src="salary.employee.user.photo"
                  alt="Photo"
                  class="avatar"
                />
              </td>
            <td>{{ salary.employee.user.name | capitalizeFirstLetter }}</td>
            <td>{{ salary.employee_salary | formatNumber }}</td>
            <td>
              <span>
                <a
                  @click.prevent="showModal(true, salary)"
                  href=""
                  class="btn btn-primary"
                  ><i class="fas fa-edit"></i
                ></a>
              </span>
              /
              <span>
                <a href="" @click.prevent="deleteSalary(salary.id)" class="btn btn-danger"
                  ><i class="fas fa-trash"></i
                ></a>
              </span>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <th>SL No</th>
          <th>Photo</th>
          <th>Employee Name</th>
          <th>Total Salary</th>
          <th>Action (EDIT / DELETE)</th>
        </tfoot>
      </table>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="designationModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-if="isUpdating" class="modal-title">
              Updating Employee Salary detail
            </h5>
            <h5 v-else class="modal-title">
              Creating new Employee Salary Detail
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="createAndUpdateSalary">
            <div class="modal-body">
              <div class="mb-3">
                <label for="validationServerUsername">Employee name</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupPrepend3"
                      ><i class="fas fa-user-check"></i
                    ></span>
                  </div>
                  <select v-model="employee_id" 
                      :class="{ 'is-invalid': !!salaryErrors.employee_id }" class="form-control" id="selectposition" required>
                    <option value="" disabled selected>Select employee</option>
                    <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{ employee.user.name }}</option>
                  </select>
                   <div v-if="!!salaryErrors.employee_id" class="invalid-feedback">
                    {{ salaryErrors.employee_id[0] }}
                  </div>
                </div>
              </div>
             

              <div class="mb-3">
                  <label for="validationServersalary">Employee Salary</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupPrepend3"
                        > <i class="fas fa-money-check    "></i></span>
                    </div>
                    <input
                      v-model="employee_salary"
                      :class="{ 'is-invalid': !!salaryErrors.employee_salary }"
                      type="number"
                      class="form-control"
                      id="validationServersalary"
                      placeholder="Employee's total salary ?"
                      aria-describedby="inputGroupPrepend3"
                      required
                    />
                    <div v-if="!!salaryErrors.employee_salary" class="invalid-feedback">
                    {{ salaryErrors.employee_salary[0] }}
                  </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">
                Close
              </button>
              <button v-if="isUpdating" type="submit" class="btn btn-primary">
                Update
              </button>
              <button v-else type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions} from 'vuex'
export default {
  data() {
    return {
      isUpdating: false,
      employee_id: null,
      employee_salary: null,
      id: null
    };
  },

  watch: {
    dialog(new_val) {
      if (new_val) {
        $("#designationModal").modal("hide");
        this.employee_id = null
        this.employee_salary = null
        this.id = null
      }
    },
  },

  computed: {
    ...mapGetters({
      salaries: 'getSalaries',
      salaryErrors: "getSErrors",
      dialog: "getCloseDialogS",
      employees: 'getEmployees'
    })
  },

  mounted() {
    this.getAllSalaries()
    this.getAllEmployees()
  },

  methods: {

...mapActions({
  getAllSalaries: 'getSalariesAction',
  createSalary: "createSalaryAction",
  updateSalary: "updateSalaryAction",
  destroySalary: "deleteSalaryAction",
  getAllEmployees: 'getEmployeesAction'

}),

  showModal(updating, designation) {
      this.isUpdating = updating;
      if (this.isUpdating) {
        this.id = designation.id;
        this.employee_id = designation.employee_id;
        this.employee_salary = designation.employee_salary;
      }
      $("#designationModal").modal("show");
    },

    createAndUpdateSalary() {
      const data = {
        employee_salary: this.employee_salary,
        employee_id: this.employee_id,
      };

      if (this.isUpdating) {
        const updateData = {
          id: this.id,
          data: data,
        };
        this.updateSalary(updateData);
      } else {
        this.createSalary(data);
      }
    },

    deleteSalary(id) {
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
            this.destroySalary(id);
          }
        });
    },
  },
};
</script>