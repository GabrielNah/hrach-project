export default function calculateDiscountedPrice(price,discount) {
    return +( ((+price*100/100) * ( 100 - +(discount*100/100) )/100) ).toFixed(2);
}
