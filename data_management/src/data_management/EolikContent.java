package data_management;

/**
 *
 * @author Alberto
 */
public class EolikContent implements java.io.Serializable {

    //private String serial_data = "";
    //private String main_data = "";
    //private String partial_data = "";
    //private String[][] data_array = new String[2][2];
    private int[][] parse_data = new int[2][2];
    private int serial_number = 0;
    private String date = "";

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public int[][] getParse_data() {
        return parse_data;
    }

    public void setParse_data(int[][] parse_data) {
        this.parse_data = parse_data;
    }

    public int getSerial_number() {
        return serial_number;
    }

    public void setSerial_number(int serial_number) {
        this.serial_number = serial_number;
    }
}
