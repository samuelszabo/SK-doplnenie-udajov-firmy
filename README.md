# SK-doplnenie-udajov-firmy
JS+PHP doplnenie údajov firmy do formulára (fakturačné údaje, dodacia adresa, ..) podľa IČO / DIČ + overenie registrácie na DPH (IČ DPH). Dáta sú čerpané z www.orsr.sk, cez API www.registeruz.sk a registrácia DPH z EU VIES.

Example: http://najdeniefirmy.soin.sk/

# FAQ

- dáta o firmách sa čerpaju z Obchodného registra (s.r.o., a.s.) a cez API www.registeruz.sk
- http://www.registeruz.sk/cruz-public/version/186074/static/api.html
- dáta z registeruz.sk sú oneskorené dát pri nových firmách alebo pri zmenách (spravidla 1x ročne po podaní uzávierky)
- často pri nových firmách tiež nie je doplnené DIČ v registeruz.sk (až kým firma nepodá ÚZ)
- ak je známe DIČ, overenie IČ DPH je online http://ec.europa.eu/taxation_customs/vies/?locale=sk
