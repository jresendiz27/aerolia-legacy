package data_management;

/**
 *
 * @author Alberto
 */
public class HistoryContent implements java.io.Serializable {

    private String date = "";
    private String content = "";
    private String error = "";
    private int serial = 0;
    private int id_error=-1;

    public HistoryContent() {
    }

    public HistoryContent(String er, String main_data, int serial_number, int iderror) {
        this.content=main_data;
        this.error=er;
        this.serial=serial_number;
        this.id_error=iderror;
    }

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public String getDate() {
        return date;
    }

    public int getId_error() {
        return id_error;
    }

    public void setId_error(int id_error) {
        this.id_error = id_error;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getError() {
        return error;
    }

    public void setError(String error) {
        this.error = error;
    }

    public int getSerial() {
        return serial;
    }

    public void setSerial(int serial) {
        this.serial = serial;
    }
}
