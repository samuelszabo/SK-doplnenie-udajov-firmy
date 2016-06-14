# SK-doplnenie-udajov-firmy
JS+PHP doplnenie údajov firmy do formulára (fakturačné údaje, dodacia adresa, ..) podľa IČO / DIČ + overenie registrácie na DPH (IČ DPH). Dáta sú čerpané cez API www.registeruz.sk a registrácia DPH z EU VIES.

Example: http://najdeniefirmy.soin.sk/

# FAQ

- dáta o firmách sa čerpaju cez API www.registeruz.sk, nie z Obchodného registra
- http://www.registeruz.sk/cruz-public/version/186074/static/api.html
- znamená to značné oneskorenie dát pri nových firmách alebo pri zmenách (spravidla 1x ročne po podaní uzávierky)
- často pri nových firmách tiež nie je doplnené DIČ (až kým firma nepodá ÚZ)
- ak je známe DIČ, overenie IČ DPH je online http://ec.europa.eu/taxation_customs/vies/?locale=sk
