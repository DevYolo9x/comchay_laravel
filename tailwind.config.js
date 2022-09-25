module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./app/Components/Html.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      spacing: {
        35: "35px",
      },
      colors: {
        grayf5f: "#F5F4F2",
        Orangefc5:"#fc5a34",
        grayf4f: "#F4F4F4",


      },
      boxShadow: {
        'dark': '0 1px 2px 0 rgba(255, 255, 255, 0.05)', //White shadow
      },
      fontSize: {
        f10: ['10px'],
        f11: ['11px'],
        f12: ['12px', '14px'],
        f13: ['13px'],
        f14: ['14px'],
        f15: ['15px', '20px'],
        f16: ['16px', '20px'],
        f17: ['17px'],
        f18: ['18px','20px'],
        f19: ['19px'],
        f20: ['20px' ,'24px'],
        f21: ['21px'],
        f22: ['22px'],
        f23: ['23px'],
        f24: ['24px','28px'],
        f25: ['25px','28px'],
        f26: ['26px'],
        f27: ['27px'],
        f28: ['28px','40px'],
        f29: ['29px'],
        f30: ['30px', '32px'],
        f31: ['31px'],
        f32: ['32px', '36px'],
        f33: ['33px'],
        f34: ['34px'],
        f35: ['35px'],
        f36: ['36px'],
        f37: ['37px'],
        f38: ['38px'],
        f39: ['39px'],
        f40: ['40px'],
        f41: ['41px'],
        f42: ['42px'],
        f50: ['50px'],
        f54: ['54px', '60px'],
      },
      spacing: {
        '0px': '0px','1px': '1px','2px': '2px','3px': '3px','4px': '4px','5px': '5px','6px': '6px','7px': '7px','8px': '8px','9px': '9px','10px': '10px','11px': '11px','12px': '12px', '13px': '13px',
        '14px': '14px','15px': '15px','16px': '16px','17px': '17px','18px': '18px', '19px': '19px','20px': '20px','21px': '21px','22px': '22px','23px': '23px','24px': '24px','25px': '25px','26px': '26px','27px': '27px','28px': '28px','29px': '29px','30px': '30px',
        '36px': '36px', '50px': '50px', '54px': '54px', '60px': '60px','78px': '78px','100px': '100px','130px': '130px',

      },
      translate: {
      '50': '50%',

      },
    },
  },
  plugins: [
    function ({ addComponents }) {
      addComponents({
        ".container": {
          width: "100%",
          // marginLeft: 'auto',
          // marginRight: 'auto',
          // paddingLeft: '2rem',
          // paddingRight: '2rem',
          "@screen sm": {
            maxWidth: "640px",
          },
          "@screen md": {
            maxWidth: "768px",
          },
          "@screen lg": {
            maxWidth: "1024px",
          },
          "@screen xl": {
            maxWidth: "1140px",
          },
        },
      });
    },

  ]
}
