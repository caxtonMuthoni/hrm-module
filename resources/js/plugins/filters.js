import Vue from 'vue'
import moment from 'moment'


// Filter to format number

Vue.filter('formatNumber', (number) => {
  if (!number) {
    return '0.00'
  }

  let final = ''
  const digits = parseFloat(number).toFixed(2).toString().split('.')
  let decimal = digits[1]
  const wholeNum = digits[0]
  wholeNum && wholeNum.split('').reverse().forEach(function (num, index) {
    if ((index + 1) % 3 === 0) {
      final = ',' + num + final
    } else {
      final = num + final
    }
  })

  if (final[0] === ',') {
    final = final.substr(1)
  }
  if (!decimal) {
    decimal = '00'
  }

  return final + '.' + decimal
})
// Format wholenumber


// Format date from now
Vue.filter('fromNow', (date) => {
  return moment(date).fromNow(true)
})


Vue.filter('capitalizeFirstLetter', (sentence) => {
  return sentence.charAt(0).toUpperCase() + sentence.slice(1)
})
