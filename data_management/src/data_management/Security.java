package data_management;

import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.security.NoSuchAlgorithmException;
import java.util.ArrayList;
import javax.crypto.Cipher;
import javax.crypto.KeyGenerator;
import javax.crypto.SealedObject;
import javax.crypto.SecretKey;

/**
 *
 * @author Alberto
 */
public class Security {

    private static Cipher ecipher = null;
    private static Cipher dcipher = null;
    private static SecretKey key = null;
    private static SealedObject sealedObject = null;

    Security() {
    }

    public static SealedObject encryptArrayContent(ArrayList<EolikContent> str) {
        try {
            checkKey();
            ecipher = Cipher.getInstance("DES");
            ecipher.init(Cipher.ENCRYPT_MODE, key);
            sealedObject = new SealedObject(str, ecipher);
            // Encode the string into bytes using utf-8          
            return sealedObject;
        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }

    public static SealedObject encryptObjectContent(EolikContent str) {
        try {
            checkKey();
            ecipher = Cipher.getInstance("DES");
            ecipher.init(Cipher.ENCRYPT_MODE, key);
            sealedObject = new SealedObject(str, ecipher);
            // Encode the string into bytes using utf-8
            return sealedObject;
        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }

    public static SealedObject encrypArraytLog(ArrayList<HistoryContent> str) {
        try {
            checkKey();
            ecipher = Cipher.getInstance("DES");
            ecipher.init(Cipher.ENCRYPT_MODE, key);
            sealedObject = new SealedObject(str, ecipher);
            // Encode the string into bytes using utf-8
            return sealedObject;
        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }

    public static SealedObject encrypObjecttLog(HistoryContent str) {
        try {
            checkKey();
            ecipher = Cipher.getInstance("DES");
            ecipher.init(Cipher.ENCRYPT_MODE, key);
            sealedObject = new SealedObject(str, ecipher);
            // Encode the string into bytes using utf-8
            return sealedObject;
        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }

    public static ArrayList<HistoryContent> decryptArrayLog(SealedObject str) {
        try {
            checkKey();
            dcipher = Cipher.getInstance("DES");
            dcipher.init(Cipher.DECRYPT_MODE, key);            
            return (ArrayList<HistoryContent>) str.getObject(key);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }

    }

    public static HistoryContent decryptObjectLog(SealedObject str) {
        try {
            checkKey();
            dcipher = Cipher.getInstance("DES");
            dcipher.init(Cipher.DECRYPT_MODE, key);            
            return (HistoryContent) str.getObject(key);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }

    }

    public static ArrayList<EolikContent> decryptArrayContent(SealedObject str) {
        try {
            checkKey();
            dcipher = Cipher.getInstance("DES");
            dcipher.init(Cipher.DECRYPT_MODE, key);            
            return (ArrayList<EolikContent>) str.getObject(key);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }

    }

    public static EolikContent decryptObjectContent(SealedObject str) {
        try {
            checkKey();
            dcipher = Cipher.getInstance("DES");
            dcipher.init(Cipher.DECRYPT_MODE, key);            
            return (EolikContent) str.getObject(key);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }

    }

    public static void createKey() {
        try {
            key = KeyGenerator.getInstance("DES").generateKey();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static void saveKey() {

        try {
            ObjectOutputStream out = new ObjectOutputStream(new FileOutputStream("DES.key"));
            out.writeObject(key);
            out.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static boolean readKey() {
        try {
            ObjectInputStream out = new ObjectInputStream(new FileInputStream("DES.key"));
            key = (SecretKey) out.readObject();
            return true;
        } catch (Exception e) {
            e.printStackTrace();
            return false;
        }
    }

    public static void checkKey() {
        if (!readKey()) {
            createKey();
            saveKey();
        }
    }
}
