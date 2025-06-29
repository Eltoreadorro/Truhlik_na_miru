<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Formulář pro vrácení zboží</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 20px; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .info-box { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; background-color: #f9f9f9; }
        .section { margin-bottom: 25px; }
        .section h2 { font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        .checkbox { display: inline-block; width: 20px; height: 20px; border: 1px solid #000; margin-right: 10px; }
        .signature { margin-top: 50px; }
        .footer { font-size: 12px; color: #666; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Formulář pro vrácení zboží</h1>
        <p>Číslo objednávky: _________________________</p>
    </div>

    <div class="info-box">
        <p><strong>Důležité informace:</strong></p>
        <ul>
            <li>Zboží lze vrátit do 14 dnů od převzetí</li>
            <li>Zboží musí být nepoškozené, v původním obalu</li>
            <li>Formulář vyplňte čitelně a kompletně</li>
        </ul>
    </div>

    <div class="section">
        <h2>Údaje o zákazníkovi</h2>
        <table>
            <tr>
                <td width="30%">Jméno a příjmení:</td>
                <td>_________________________________________</td>
            </tr>
            <tr>
                <td>Adresa:</td>
                <td>_________________________________________</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>_________________________________________</td>
            </tr>
            <tr>
                <td>Telefon:</td>
                <td>_________________________________________</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Vracené zboží</h2>
        <table>
            <thead>
                <tr>
                    <th>Název zboží</th>
                    <th>Číslo výrobku</th>
                    <th>Množství</th>
                    <th>Důvod vrácení</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>_________________________</td>
                    <td>_________________________</td>
                    <td>_________________________</td>
                    <td>_________________________</td>
                </tr>
                <tr>
                    <td>_________________________</td>
                    <td>_________________________</td>
                    <td>_________________________</td>
                    <td>_________________________</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Způsob náhrady</h2>
        <p><span class="checkbox"></span> Vrátit peníze na původní platební metodu</p>
        <p><span class="checkbox"></span> Výměna za jiné zboží</p>
        <p><span class="checkbox"></span> Uložit jako kredit na další nákup</p>
    </div>

    <div class="signature">
        <p>Datum: _________________________</p>
        <p>Podpis: _________________________</p>
    </div>

    <div class="footer">
        <p><strong>Kam zaslat:</strong> {{ config('app.name') }}, Sulicka 42, Sulice, 25168 Praha-vychod</p>
        <p><strong>Kontakt:</strong> truhliknamiru@gmail.com | +420 606 912 403</p>
    </div>
</body>
</html>
