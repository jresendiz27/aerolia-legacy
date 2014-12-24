package client_management;

import data_management.EolikContent;
import data_management.FileManager;
import data_management.HistoryContent;
import data_management.Tools;

/**
 *
 * @author Alberto
 */
public class data_reception {

    private String serial_data;
    private int serial_number;
    private String main_data;
    private int locate;
    private String partial_data;
    private String arr_data[][] = new String[2][2];
    private EolikContent eoc = new EolikContent();
    private HistoryContent hc = null;

    public data_reception() {
    }

    public void serial(String data) throws Exception {
        this.serial_data = data.toUpperCase();
        if (this.serial_data.indexOf("0X") != -1 && (this.serial_data.indexOf("FF") != -1)) {
            try {
                this.serial_number = Integer.parseInt(this.serial_data.substring(this.serial_data.indexOf("0X") + 2, this.serial_data.indexOf("FF")));
                eoc.setSerial_number(serial_number);
            } catch (Exception e) {
                this.serial_number = -1;
                hc = new HistoryContent("Error 1: Número de Serie Erroneo.Posible falla general", main_data, serial_number, 1);
                if (!(new Client_Socket().run((Object) hc, 4))) {
                    FileManager.saveLog(hc);
                }
            }
        }
    }

    public void date() {
    }

    public void receive(String data) throws Exception {
        this.main_data = data.toUpperCase();
        if (main_data.indexOf("0X") != -1 && this.serial_number != -1) {
            locate = main_data.indexOf("FF");
            if (locate != -1) {
                partial_data = main_data.substring(2, locate);
                if (main_data.indexOf("DA") != -1) {
                    eoc.setDate(Tools.getDateTime(partial_data));
                    //aqui se le mandaria un msg al pic de que la fecha se recibio,se vuelven a recibir los datos
                } else {
                    eoc.setDate(Tools.getDateTime());
                }
                if ((partial_data.length() % 7) == 0) {
                    arr_data=Tools.split(partial_data);
                    eoc.setParse_data(Tools.parseInt(arr_data));
                } else {
                }
                if (!(new Client_Socket().run((Object) eoc, 3))) {
                    FileManager.saveData(eoc);
                }
            } else {
                hc = new HistoryContent("Error 3: Datos sin final.Posible falla en componente fisico.Guardado en registro local", main_data, serial_number, 3);
                if (!(new Client_Socket().run((Object) hc, 4))) {
                    FileManager.saveLog(hc);
                }

            }
        } else {
            hc = new HistoryContent("Error 4: Imposible iniciar captura de datos.Posible falla general. Guardado en registro local", main_data, serial_number, 4);
            if (!(new Client_Socket().run((Object) hc, 4))) {
                FileManager.saveLog(hc);
            }
        }
    }
}
