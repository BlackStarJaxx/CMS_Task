module.exports = {
    convert: (from,to,amount) => {
     let currency = JSON.parse(localStorage.getItem('currencies'));
     console.log(from,to,amount)
     var exchange = currency.find(function(element) {
            return element.name == to;
        });
     var exchange2 = currency.find(function(element) {
            return element.name == from;
        });

        if (from == "EUR")
            return amount * exchange.exchange;
        if (to == "EUR")
            return amount / exchange2.exchange;
        return amount
    }
}

