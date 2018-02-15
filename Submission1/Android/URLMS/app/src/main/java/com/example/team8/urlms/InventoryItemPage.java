package com.example.team8.urlms;

import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import java.text.SimpleDateFormat;
import java.util.Date;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.controller.Controller;
import ca.mcgill.ecse321.urlms.controller.FundingController;
import ca.mcgill.ecse321.urlms.controller.InventoryController;
import ca.mcgill.ecse321.urlms.controller.StaffController;
import ca.mcgill.ecse321.urlms.model.URLMS;

import static android.icu.lang.UCharacter.GraphemeClusterBreak.V;
import static com.example.team8.urlms.R.id.addFundingButton;
import static com.example.team8.urlms.R.id.addQuantityButton;

public class InventoryItemPage extends AppCompatActivity {

    private URLMS urlms;
    private String fileName;

    Controller controller = new Controller();
    InventoryController ic = new InventoryController();
    FundingController fc = new FundingController();

    Button backButton;
    Button editButton;
    Button deleteButton;
    Button addQuantityButton;

    TextView currentName;
    TextView currentCost;
    TextView currentQuantity;
    TextView totalCostDisplay;
    TextView actualQuantity;

    EditText editName;
    EditText editCost;

    private int position;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inventory_item_page);

        //retrieve bundle
        position = getIntent().getExtras().getInt("itemPosition");

        //load controller and model
        fileName = getFilesDir().getAbsolutePath() + "/urlms.xml";
        URLMSApplication.setFilename(fileName);
        urlms = URLMSApplication.getURLMS();


        backButton = (Button) findViewById(R.id.backButton);
        editButton = (Button) findViewById(R.id.editButton);
        deleteButton = (Button) findViewById(R.id.deleteButton);
        addQuantityButton = (Button) findViewById(R.id.addQuantityButton);

        editName = (EditText) findViewById(R.id.editName);
        editCost = (EditText) findViewById(R.id.editCost);

        currentName = (TextView) findViewById(R.id.itemName);
        currentCost = (TextView) findViewById(R.id.itemCost);
        currentQuantity = (TextView) findViewById(R.id.quantityText);
        totalCostDisplay = (TextView) findViewById(R.id.totalCostDisplay);
        actualQuantity = (TextView) findViewById(R.id.currentQuantityText);

        currentName.setText(ic.viewInventoryItemName(position));
        currentCost.setText(ic.viewInventoryItemCost(position));
        editName.setText(ic.viewInventoryItemName(position));
        editCost.setText(ic.viewInventoryItemCost(position));


        //display inventory UI
        if(ic.inventoryItemIsEquipment(position)){
            currentQuantity.setVisibility(View.INVISIBLE);
            actualQuantity.setVisibility(View.INVISIBLE);
            actualQuantity.setText("0");
            totalCostDisplay.setVisibility(View.INVISIBLE);
            addQuantityButton.setVisibility(View.INVISIBLE);
        }
        //display supply UI
        else {
            actualQuantity.setText(ic.viewSupplyItemQuantity(position));
            currentQuantity.setText("Quantity");
            double costPerUnit = Double.parseDouble(ic.viewInventoryItemCost(position));
            int currentQuantity = Integer.parseInt(ic.viewSupplyItemQuantity(position));
            double totalCost = costPerUnit * currentQuantity;
            totalCostDisplay.setVisibility(View.VISIBLE);
            addQuantityButton.setVisibility(View.VISIBLE);
            actualQuantity.setVisibility(View.VISIBLE);
            totalCostDisplay.setText("The total cost for this supply is " +totalCost + ".");
        }

        setEditButton();
        setBackButton();
        setDeleteButton();
        setAddQuantityButton();
    }

    public void setAddQuantityButton(){
        addQuantityButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final AlertDialog.Builder mBuilder = new AlertDialog.Builder(InventoryItemPage.this);
                View mView = getLayoutInflater().inflate(R.layout.dialog_add_quantity, null);
                final EditText mAmount = (EditText) mView.findViewById(R.id.editTextAmount);
                Button mConfirm = (Button) mView.findViewById(R.id.buttonConfirm);
                mBuilder.setView(mView);
                final AlertDialog dialog = mBuilder.create();
                dialog.show();
                mConfirm.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        if(!mAmount.getText().toString().isEmpty()){
                            //compute new quantity
                            int amount = Integer.parseInt(mAmount.getText().toString());
                            int currentQuantity = Integer.parseInt(ic.viewSupplyItemQuantity(position));
                            int newQuantity = amount+currentQuantity;

                            //edit
                            ic.editInventoryItemDetails(position, ic.viewInventoryItemName(position)
                            ,Double.parseDouble(ic.viewInventoryItemCost(position)), newQuantity);
                            //record transaction to Supply Funds account
                            String date = new SimpleDateFormat("MM-dd-yyyy").format(new Date());
                            fc.addTransaction(date, amount*Double.parseDouble(ic.viewInventoryItemCost(position)),
                                    "Purchased " + amount + " " + "additional " + ic.viewInventoryItemName(position)+".", "Supply Funds");

                            toastMessage("Quantity added, expense recorded.");
                            dialog.dismiss();
                            recreate();
                        }
                        //invalid inputs
                        else{
                            toastMessage("Please fill any empty fields.");
                        }
                    }
                });
            }
        });
    }
    public void setEditButton(){
        editButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(!editCost.getText().toString().equals(".")){
                ic.editInventoryItemDetails(position, editName.getText().toString(),
                        Double.parseDouble(editCost.getText().toString())
                        , Integer.parseInt(ic.viewSupplyItemQuantity(position)));
                ic.save();
                recreate();
                toastMessage("Sucessfully updated.");}
                else{
                    toastMessage("Please fix the cost quantity");
                }
            }
        });
    }

    public void setBackButton(){
        backButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ic.save();
                finish();
            }
        });
    }

    public void setDeleteButton(){
        deleteButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ic.removeInventoryItem(position);
                ic.save();
                finish();
            }
        });
    }
    public void toastMessage(String message){
        Toast myToast= Toast.makeText(getApplicationContext(),message,Toast.LENGTH_SHORT);
        myToast.show();
    }
}
