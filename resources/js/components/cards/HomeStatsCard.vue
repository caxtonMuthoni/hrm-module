<template>
  <div class="col-lg-3 col-xs-6">
    <div class="small-box" :class="cardDetail.color">
      <div class="inner">
        <h3>{{ cardDetail.value }}</h3>

        <p>{{ cardDetail.title }}</p>
      </div>
      <div class="icon">
        <i :class="cardDetail.icon"></i>
      </div>
      <a :href="cardDetail.route" class="small-box-footer"
        >More info <i class="fa fa-arrow-circle-right"></i
      ></a>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    cardDetail: {
      type: Object,
      required: true,
    },
  },
};
</script>