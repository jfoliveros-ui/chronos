<div style="font-family: Arial, sans-serif; color: #333; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px; max-width: 600px; margin: auto;">
    <h1 style="text-align: center; color: #0044cc; font-size: 24px;">Confirmación de Asignación de Horario</h1>

    <p style="font-size: 16px; line-height: 1.6;">
        Estimado(a) Docente,
    </p>

    <p style="font-size: 16px; line-height: 1.6;">
        Nos complace informarle que se le ha asignado la siguiente asignatura:
    </p>

    <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #0044cc; margin: 15px 0; border-radius: 4px;">
        <p style="margin: 0; font-size: 16px;"><strong>Centro de Tutoria:</strong> {{$data['cetap']}}</p>
        <p style="margin: 0; font-size: 16px;"><strong>Asignatura:</strong> {{$data['subject']}}</p>
        <p style="margin: 0; font-size: 16px;"><strong>Jornada:</strong> {{$data['working_day']}}</p>
        <p style="margin: 0; font-size: 16px;"><strong>Fecha:</strong> {{$data['dates']}}</p>
        <p style="margin: 0; font-size: 16px;"><strong>Modalidad:</strong> {{$data['mode']}}</p>
    </div>

    <p style="font-size: 16px; line-height: 1.6;">
        Por favor, ingresar al aplicativo edutime para realizar la aceptación de la asignación.
    </p>

    <p style="font-size: 16px; line-height: 1.6;">
        Cordialemente,
    </p>

    <p style="font-size: 12px; font-weight: bold; color: #0044cc;">Registro y Control</p>
</div>
