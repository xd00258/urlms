package ca.mcgill.ecse321.urlms.view;

import java.awt.BorderLayout;
import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.controller.InvalidInputException;
import ca.mcgill.ecse321.urlms.controller.InventoryController;
import ca.mcgill.ecse321.urlms.controller.StaffController;

import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.JTextField;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import javax.swing.JLabel;
import javax.swing.LayoutStyle.ComponentPlacement;
import javax.swing.JScrollPane;

public class AddInventoryItemPO extends JFrame {

	private JPanel contentPane;
	private JTextField txtItemName;
	private JTextField txtItemCost;
	public static InventoryController controller = new InventoryController();
	private JButton btnAddAsEquipment;
	private JTextField txtQuantity;
	private JLabel lblItemName;
	private JLabel lblItemCost;
	private JLabel lblQuantity;
	private JTextField txtItemCategory;
	private String error;
	private JButton addButton;
	private JLabel lblItemCategory;
	private JButton btnClose;
	private JLabel lblError;


	/**
	 * Create the frame.
	 */
	public AddInventoryItemPO() {
		initComponents();
	}
	
	private void initComponents(){
		setResizable(false);
		setAlwaysOnTop(true);
		setTitle("Add Inventory Item");
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 566, 320);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		
		txtItemName = new JTextField();
		txtItemName.setColumns(10);
		
		txtItemCost = new JTextField();
		txtItemCost.setColumns(10);
		
		addButton = new JButton("Add as Supply Item");
		addButton.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				
				try {
					String name = txtItemName.getText();
					double cost = Double.valueOf(txtItemCost.getText());
					int quantity = Integer.valueOf(txtQuantity.getText());
					String category = txtItemCategory.getText();
					controller.addSupplyItem(name, category, cost, quantity);
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				} catch (NumberFormatException e1) {
					error += "Please enter a valid cost (double) and/or quantity (integer) amount. ";
				} catch (RuntimeException e1) {
					error += "stuff happened. ";
				}
				refreshData();
				
			}
		});
		
		btnAddAsEquipment = new JButton("Add as Equipment Item");
		btnAddAsEquipment.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				
				try {
					String name = txtItemName.getText();
					double cost = Double.valueOf(txtItemCost.getText());
					String category = txtItemCategory.getText();
					controller.addEquipmentItem(name, category, cost);
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				} catch (NumberFormatException e1) {
					error += "Please enter a valid cost (double) and/or quantity (integer) amount. ";
				} catch (RuntimeException e1) {
					error += "stuff happened. ";
				}
				refreshData();
			}
		});
		
		txtQuantity = new JTextField();
		txtQuantity.setColumns(10);
		
		lblItemName = new JLabel("Item Name (case-sensive):");
		
		lblItemCost = new JLabel("Item Cost (CAD, use '.' for floating point):");
		
		lblQuantity = new JLabel("Quantity (leave empty if adding equipment):");
		
		txtItemCategory = new JTextField();
		txtItemCategory.setColumns(10);
		
		lblItemCategory = new JLabel("Item Category (e.g. Computer, Chair):");
		
		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				close();
			}
		});
		
		JScrollPane scrollPane = new JScrollPane();
		GroupLayout gl_contentPane = new GroupLayout(contentPane);
		gl_contentPane.setHorizontalGroup(
			gl_contentPane.createParallelGroup(Alignment.LEADING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addContainerGap(40, Short.MAX_VALUE)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addGroup(gl_contentPane.createParallelGroup(Alignment.TRAILING)
								.addGroup(gl_contentPane.createSequentialGroup()
									.addComponent(lblQuantity)
									.addPreferredGap(ComponentPlacement.RELATED)
									.addComponent(txtQuantity, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE))
								.addGroup(gl_contentPane.createSequentialGroup()
									.addComponent(lblItemCost)
									.addPreferredGap(ComponentPlacement.RELATED)
									.addComponent(txtItemCost, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE))
								.addGroup(gl_contentPane.createSequentialGroup()
									.addComponent(lblItemCategory)
									.addPreferredGap(ComponentPlacement.RELATED)
									.addComponent(txtItemCategory, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE))
								.addGroup(gl_contentPane.createSequentialGroup()
									.addComponent(lblItemName)
									.addPreferredGap(ComponentPlacement.RELATED)
									.addComponent(txtItemName, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)))
							.addGap(36))
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(addButton)
							.addGap(18)
							.addComponent(btnAddAsEquipment)
							.addGap(17)
							.addComponent(btnClose)
							.addGap(30))
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 466, GroupLayout.PREFERRED_SIZE)
							.addGap(37))))
		);
		gl_contentPane.setVerticalGroup(
			gl_contentPane.createParallelGroup(Alignment.LEADING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGap(23)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtItemName, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblItemName))
					.addPreferredGap(ComponentPlacement.RELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtItemCategory, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblItemCategory))
					.addPreferredGap(ComponentPlacement.RELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtItemCost, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblItemCost))
					.addPreferredGap(ComponentPlacement.RELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtQuantity, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblQuantity))
					.addPreferredGap(ComponentPlacement.RELATED, 10, Short.MAX_VALUE)
					.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 45, GroupLayout.PREFERRED_SIZE)
					.addGap(11)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(addButton)
						.addComponent(btnClose)
						.addComponent(btnAddAsEquipment))
					.addGap(21))
		);
		
		lblError = new JLabel("Feel free to add some inventory items.");
		scrollPane.setViewportView(lblError);
		contentPane.setLayout(gl_contentPane);
	}
	
	private void refreshData(){
		if(error.length() > 0){
			lblError.setText(error);
		}
		else{
			lblError.setText("Item successfully added.");
		}
	}
	
	public void close() { 
		this.setVisible(false);
	    this.dispose();
	}
}
