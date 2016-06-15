# SK-doplnenie-udajov-firmy
JS+PHP doplnenie údajov firmy do formulára (fakturačné údaje, dodacia adresa, ..) podľa IČO / DIČ + overenie registrácie na DPH (IČ DPH).

# PHP parser ORSR.sk - náhrada ORSR.sk api
Orsr.sk nemá verejné API, dáta sa získavajú GET requestom cez vyhľadávanie podľa IČO a parsujú sa z prvého nájdeného výsledku (nemusia byť vždy presné, najmä ak existujú dva rôzne subjekty s rovnakým IČO na rôznych súdoch - ide o minoritu).

# PHP API registeruz.sk
Class pre vyhľadanie subjektu a stiahnutie údajov podľa IČO alebo DIČ z registra účtovnych závierok. Dáta sú aktualizované oneskorene (spravidla 1x ročne po podaní a spracovaní účtovnej závierky), slúži najmä na dohľadanie subjektov ktoré sa nenašli v ORSR (napríklad živnostníci, združenia, ..) a doplnenie DIČ ktoré nie je v ORSR
Dokumentácia k API: http://www.registeruz.sk/cruz-public/version/186074/static/api.html

# PHP parser ORSR.sk - náhrada ORSR.sk api
Dáta sú čerpané z www.orsr.sk, cez API www.registeruz.sk a registrácia DPH z EU VIES.

#Live example

http://najdeniefirmy.soin.sk/

# FAQ

- dáta o firmách sa čerpaju z Obchodného registra (s.r.o., a.s.) a cez API www.registeruz.sk
- dáta z registeruz.sk sú oneskorené dát pri nových firmách alebo pri zmenách (spravidla 1x ročne po podaní uzávierky)
- často pri nových firmách tiež nie je doplnené DIČ v registeruz.sk (až kým firma nepodá ÚZ)
- ak je známe DIČ, overenie IČ DPH je online http://ec.europa.eu/taxation_customs/vies/?locale=sk
